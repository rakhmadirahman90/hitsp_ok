<?php

namespace App\Http\Controllers;

use App\Models\HotspotUser;
use App\Models\Notification; // ?? TAMBAHAN WAJIB
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class HotspotController extends Controller
{
    public function create(): View
    {
        $hotspots = HotspotUser::where('user_id', Auth::id())
            ->latest()
            ->get();

        $user = Auth::user();

        $adminDefault = [
            'pj_nama' => 'Budi Santoso',
            'pj_nip' => '199008172014041001',
            'pj_jabatan' => 'Admin TIK',
            'pj_telepon' => '082112345678',
        ];

        return view('user.hotspot_saya', compact(
            'hotspots',
            'adminDefault',
            'user'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'akses' => 'required|string|in:Lembaga,Dosen,Staf,Mahasiswa,Lain-lain',
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'akun_hotspot' => 'required|in:Pengguna Baru,Reset Password',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'nama_hotspot' => 'required|string|max:255',

            'pj_nama' => 'required|string|max:255',
            'pj_nip' => 'required|string|max:50',
            'pj_jabatan' => 'required|string|max:255',
            'pj_telepon' => 'required|string|max:20',

            'persetujuan' => 'required',
        ]);

        $cekPending = HotspotUser::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($cekPending) {
            return redirect()->back()
                ->with('error', 'Anda masih memiliki permohonan yang sedang diproses.');
        }

        try {
            DB::beginTransaction();

            HotspotUser::create([
                'user_id' => Auth::id(),
                'akses' => $validated['akses'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jabatan' => $validated['jabatan'],
                'nip' => $validated['nip'],
                'akun_hotspot' => $validated['akun_hotspot'],
                'no_telepon' => $validated['no_telepon'],
                'email' => $validated['email'],
                'nama_hotspot' => $validated['nama_hotspot'],
                'pj_nama' => $validated['pj_nama'],
                'pj_nip' => $validated['pj_nip'],
                'pj_jabatan' => $validated['pj_jabatan'],
                'pj_telepon' => $validated['pj_telepon'],
                'persetujuan' => 0,
                'status' => 'pending',
            ]);

            // ================================
            // ?? TAMBAHAN NOTIFIKASI (ADMIN)
            // ================================
            Notification::create([
                'user_id' => null,
                'title' => 'Permohonan Hotspot Baru',
                'message' => $validated['nama_lengkap'] . ' mengajukan hotspot: ' . $validated['nama_hotspot'],
                'is_read' => 0,
            ]);

            try {
                $column = null;

                if (Schema::hasColumn('layanans', 'user_id')) {
                    $column = 'user_id';
                } elseif (Schema::hasColumn('layanans', 'id_user')) {
                    $column = 'id_user';
                } elseif (Schema::hasColumn('layanans', 'users_id')) {
                    $column = 'users_id';
                }

                if ($column) {
                    DB::table('layanans')->insert([
                        $column => Auth::id(),
                        'layanan' => 'Permohonan Hotspot - ' . $validated['nama_hotspot'],
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Sinkron layanan gagal: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('hotspot.my')
                ->with('success', 'Permohonan berhasil dikirim.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Hotspot Error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function myHotspot(): View
    {
        $hotspots = HotspotUser::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $adminDefault = [
            'pj_nama' => 'Budi Santoso',
            'pj_nip' => '199008172014041001',
            'pj_jabatan' => 'Admin TIK',
            'pj_telepon' => '082112345678',
        ];

        return view('user.hotspot_saya', compact('hotspots', 'adminDefault'));
    }

    public function show($id): View
    {
        $hotspot = HotspotUser::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.hotspot_detail', compact('hotspot'));
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $hotspot = HotspotUser::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->findOrFail($id);

            $hotspot->delete();

            return redirect()->back()
                ->with('success', 'Permohonan dibatalkan.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal membatalkan.');
        }
    }
}