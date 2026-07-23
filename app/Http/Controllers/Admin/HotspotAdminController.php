<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotspotUser;
use App\Models\HotspotCredential;
use App\Mail\HotspotApprovedMail;
// TAMBAHKAN IMPORT BERIKUT
use App\Mail\HotspotRejectedMail; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HotspotAdminController extends Controller
{
    public function index()
    {
        $hotspots = HotspotUser::orderBy('id', 'desc')->get();
        return view('admin.permohonanhospot', compact('hotspots'));
    }

    public function show($id)
    {
        $hotspot = HotspotUser::findOrFail($id);
        return view('admin.detailhotspot', compact('hotspot'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'nip' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $hotspot = new HotspotUser();
            $hotspot->user_id = auth()->id(); 
            $hotspot->nama_lengkap = $request->nama_lengkap;
            $hotspot->email = $request->email;
            $hotspot->nip = $request->nip;
            $hotspot->jabatan = $request->jabatan;
            $hotspot->no_telepon = $request->no_telepon;
            $hotspot->akses = $request->akses;
            $hotspot->nama_hotspot = $request->nama_hotspot;

            $hotspot->persetujuan = 0; 
            $hotspot->status = 'pending'; 
            
            $hotspot->save();
            $hotspot->refresh();

            $this->syncDashboardStatus($hotspot->user_id, 'pending');

            DB::commit();
            return redirect()->route('admin.hotspot.index')->with('success', 'Permohonan berhasil dibuat. Status saat ini: PENDING (0).');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal store hotspot: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat permohonan: ' . $e->getMessage());
        }
    }

    public function storeCredentials(Request $request, $id)
    {
        $request->validate([
            'username_hotspot' => 'required|string',
            'password_hotspot' => 'required|string|min:6',
        ]);

        $hotspot = HotspotUser::findOrFail($id);
        
        if ((int)$hotspot->persetujuan === 1) {
            return redirect()->back()->with('error', 'Permohonan ini sudah disetujui sebelumnya.');
        }

        $username = $request->username_hotspot;

        try {
            DB::beginTransaction();

            HotspotCredential::updateOrCreate(
                ['hotspot_user_id' => $hotspot->id],
                [
                    'username_hotspot' => $username,
                    'password_hotspot' => bcrypt($request->password_hotspot),
                ]
            );

            $hotspot->persetujuan = 1; 
            $hotspot->username_hotspot = $username; 
            $hotspot->status = 'disetujui'; 
            
            if (Schema::hasColumn('hotspot_users', 'password_hotspot')) {
                $hotspot->password_hotspot = $request->password_hotspot;
            }
            $hotspot->save();

            $this->syncDashboardStatus($hotspot->user_id, 'disetujui');

            DB::commit();

            try {
                Mail::to($hotspot->email)->send(
                    new HotspotApprovedMail($hotspot, $username, $request->password_hotspot)
                );
            } catch (\Exception $e) {
                Log::error('Gagal kirim email: ' . $e->getMessage());
            }

            return redirect()->route('admin.hotspot.index')
                ->with('success', 'Hotspot Berhasil Disetujui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal store credentials: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses persetujuan.');
        }
    }

    /**
     * FUNGSI PENOLAKAN DENGAN NOTIFIKASI EMAIL (PERBAIKAN)
     */
    public function tolak(Request $request, $id)
    {
        $request->validate(['alasan_tolak' => 'required|string|min:5']);
        $hotspot = HotspotUser::findOrFail($id);

        try {
            DB::beginTransaction();

            $hotspot->persetujuan = 2; 
            $hotspot->status = 'ditolak';

            if (Schema::hasColumn('hotspot_users', 'alasan_tolak')) {
                $hotspot->alasan_tolak = $request->alasan_tolak;
            }
            $hotspot->save();

            $this->syncDashboardStatus($hotspot->user_id, 'ditolak');

            DB::commit();

            // === TAMBAHAN KODE BARU: KIRIM EMAIL PENOLAKAN ===
            try {
                Mail::to($hotspot->email)->send(new HotspotRejectedMail($hotspot));
            } catch (\Exception $e_mail) {
                // Log jika mail server bermasalah agar tidak membuat aplikasi crash
                Log::error('Gagal kirim email penolakan hotspot: ' . $e_mail->getMessage());
            }
            // ===============================================

            return redirect()->route('admin.hotspot.index')->with('success', 'Permohonan ditolak dan notifikasi email terkirim.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal tolak hotspot: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menolak permohonan.');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $hotspot = HotspotUser::findOrFail($id);
            
            $this->syncDashboardStatus($hotspot->user_id, 'deleted'); 

            HotspotCredential::where('hotspot_user_id', $id)->delete();
            $hotspot->delete();

            DB::commit();
            return redirect()->route('admin.hotspot.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal hapus hotspot: ' . $e->getMessage());
            return redirect()->route('admin.hotspot.index')->with('error', 'Gagal menghapus data.');
        }
    }

    private function syncDashboardStatus($userId, $status)
    {
        if (!$userId) return;

        $targetColumn = null;
        if (Schema::hasColumn('layanans', 'id_user')) { $targetColumn = 'id_user'; }
        elseif (Schema::hasColumn('layanans', 'user_id')) { $targetColumn = 'user_id'; }
        elseif (Schema::hasColumn('layanans', 'users_id')) { $targetColumn = 'users_id'; }

        if ($targetColumn) {
            $query = DB::table('layanans')
                ->where($targetColumn, $userId)
                ->where(function($q) {
                    $q->where(DB::raw('LOWER(layanan)'), 'LIKE', '%hotspot%')
                      ->orWhere(DB::raw('LOWER(layanan)'), 'LIKE', '%permintaan%')
                      ->orWhere(DB::raw('LOWER(layanan)'), 'LIKE', '%permohonan%');
                });

            if ($status === 'deleted') {
                $query->delete();
            } else {
                $query->update(['status' => $status, 'updated_at' => now()]);
            }
        }
    }

    public function syncManual($id)
    {
        $hotspot = HotspotUser::findOrFail($id);
        
        $status_map = [0 => 'pending', 1 => 'disetujui', 2 => 'ditolak'];
        $current_status = $status_map[$hotspot->persetujuan] ?? 'pending';

        $hotspot->status = $current_status;
        $hotspot->save();

        $this->syncDashboardStatus($hotspot->user_id, $current_status);
            
        return redirect()->back()->with('success', 'Sinkronisasi berhasil.');
    }
}