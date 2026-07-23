<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\PermohonanEmailPribadi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EmailPribadiController extends Controller
{
    public function index()
    {
        // ================= USER LOGIN =================
        $user = Auth::user();

        // ================= DATA PERMOHONAN =================
        $permohonan = PermohonanEmailPribadi::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Ambil status terbaru untuk validasi tampilan awal halaman biasa
        $pengajuanTerakhir = $permohonan->first();
        $statusCheck = ($pengajuanTerakhir && isset($pengajuanTerakhir->status)) ? strtolower(trim($pengajuanTerakhir->status)) : null;

        return view('user.akunemailpribadi', compact('permohonan', 'user', 'statusCheck'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'jenis_pemohon'    => 'required|in:pegawai,mahasiswa',
            'fakultas'         => 'required|string|max:255',
            'jurusan'          => 'required|string|max:255',
            'jabatan'          => 'nullable|string|max:100',

            'nomor_identitas'  => 'required|digits_between:1,50',
            'no_telp'          => 'required|digits_between:8,12',

            'email_alternatif' => 'required|email|max:255',
            'file_identitas'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'email_name'       => 'required|string|min:3|max:15|regex:/^[A-Za-z0-9._-]+$/',
            'email_domain'     => 'required|string|max:50',

            // ================= CHECKBOX =================
            'agreement'        => 'required|accepted',
        ], [
            'agreement.accepted' => 'Anda harus menyetujui persyaratan.',
            'no_telp.digits_between' => 'Nomor telepon harus 8�12 digit.',
        ]);

        try {

            DB::beginTransaction();

            // ================= VALIDASI DUA KALI SUBMIT BERDASARKAN STATUS AKHIR =================
            $pengajuanTerakhir = PermohonanEmailPribadi::where('user_id', Auth::id())
                ->latest()
                ->lockForUpdate()
                ->first();

            if ($pengajuanTerakhir) {
                // Skenario 1: Jika status masih PENDING
                if ($pengajuanTerakhir->status == 'pending') {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Mohon maaf, Anda tidak dapat mengirimkan formulir baru. Masih ada formulir permohonan email Anda yang belum diproses oleh admin.'
                    ], 400);
                }

                // Skenario 2: Jika status sudah APPROVED atau ACTIVE
                if ($pengajuanTerakhir->status == 'approved' || $pengajuanTerakhir->status == 'active') {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda sudah pernah mengajukan permohonan email pribadi dan akun Anda saat ini sudah aktif.'
                    ], 400);
                }
            }

            // ================= CEK PENDING (BACKUP LAMA) =================
            $pending = PermohonanEmailPribadi::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->lockForUpdate()
                ->exists();

            if ($pending) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda masih memiliki permohonan yang sedang diproses.'
                ], 400);
            }
		$domain = Auth::user()->institution_domain;

if ($validated['jenis_pemohon'] == 'mahasiswa') {
    $emailDomain = '@mahasiswa.' . strtolower($domain) . '.ac.id';
} else {
    $emailDomain = '@' . strtolower($domain) . '.ac.id';
}

            // ================= FORMAT EMAIL =================
           $emailLengkap =
    strtolower(trim($validated['email_name'])) .
    $emailDomain;

            // ================= CEK DUPLIKAT EMAIL =================
            $cekEmail = PermohonanEmailPribadi::whereRaw(
                "LOWER(CONCAT(email_name,email_domain)) = ?",
                [$emailLengkap]
            )->exists();

            if ($cekEmail) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Nama email sudah pernah digunakan.'
                ], 400);
            }

            // ================= UPLOAD FILE =================
            $filePath = null;
            if ($request->hasFile('file_identitas')) {
                $filePath = $request->file('file_identitas')
                    ->store('uploads/identitas', 'public');
            }

            PermohonanEmailPribadi::create([
                'user_id' => Auth::id(),
                'nama_lengkap' => $validated['nama_lengkap'],
                'nomor_identitas' => Auth::user()->username,
                'email_alternatif' => $validated['email_alternatif'],
                'jenis_pemohon' => $validated['jenis_pemohon'],
                'fakultas' => $validated['fakultas'],
                'jurusan' => $validated['jurusan'],
                'jabatan' => $validated['jabatan'],
                'no_telp' => $validated['no_telp'],
                'file_identitas' => $filePath,
                'email_name' => strtolower(trim($validated['email_name'])),
               	'email_domain' => $emailDomain,
                'rek_nama' => $request->rek_nama,
                'rek_identitas' => $request->rek_identitas,
                'rek_fakultas' => $request->rek_fakultas,
                'rek_email' => $request->rek_email,
                'status' => 'pending',
            ]);

            // TAMBAHAN NOTIF
            Notification::create([
                'user_id' => null,
                'title' => 'Permohonan Email Pribadi',
                'message' => Auth::user()->name . ' mengajukan permohonan email baru',
                'is_read' => 0,
            ]);
            
            DB::commit();

            // UBAH RETURN MENJADI RESPONS JSON UNTUK DIKONSUMSI JAVASCRIPT AJAX
            return response()->json([
                'status' => 'success',
                'message' => 'Formulir permohonan berhasil dikirim. Silakan menunggu proses verifikasi oleh admin.'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            Log::error('Email Pribadi Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem, silakan coba lagi.'
            ], 500);
        }
    }
}