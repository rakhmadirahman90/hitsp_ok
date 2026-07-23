<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; // TAMBAHAN: Untuk memproses pengiriman Email Notifikasi
use Carbon\Carbon;

class EmailLembagaController extends Controller
{
    /**
     * Tampilkan form + riwayat
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $teknis = [
            'nama_teknis'        => $user->name,
            'nip_nik_nim_teknis' => $user->username,
            'email_alternatif'   => $user->email,
            'status_teknis'      => ucfirst($user->role),
            'telp_teknis'        => $user->phone ?? '',
            'jabatan_teknis'     => $user->jabatan ?? '',
        ];
        // 📝 DATA ADMIN DEFAULT
        $admin = [
            'nama_admin'    => 'Budi Santoso',
            'nip_admin'     => '199008172014041001',
            'jabatan_admin' => 'Staf Administrasi',
            'telp_admin'    => '089876789898',
            'email_admin'   => 'budisantoso@gmail.com',
        ];

        $riwayat = DB::table('permohonan_email_lembaga')
            ->where('email_alternatif', $user->email)
            ->orderBy('created_at', 'desc')
            ->get();

        // TAMBAHAN KODE BARU: Mengambil status permohonan paling terakhir untuk ditampilkan di kotak status Blade
        $email = DB::table('permohonan_email_lembaga')
            ->where('email_alternatif', $user->email)
            ->orderBy('created_at', 'desc')
            ->first();

        // Membawa variabel $email ke view agar status permohonan (Pending/Disetujui/Ditolak) muncul secara realtime
        return view('user.akunemaillembaga', compact(
	    'user',
            'riwayat',
            'teknis',
            'admin',
            'email' 
        ));
    }

    /**
     * Simpan data
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_institusi'    => 'required|string|max:255',
            'nama_kegiatan'     => 'nullable|string|max:255',
            'nama_akun'         => 'required|string|max:255',
            'email_alternatif'  => 'required|email|max:255',

            'nama_teknis'       => 'required|string|max:255',
            'nip_nik_nim_teknis'=> 'required|string|max:50',
            'jabatan_teknis'    => 'required|string|max:255',
            'status_teknis'     => 'required|string|max:255',
            'telp_teknis'       => 'required|string|max:20',

            'nama_admin'        => 'required|string|max:255',
            'nip_admin'         => 'required|string|max:50',
            'jabatan_admin'     => 'required|string|max:255',
            'telp_admin'        => 'required|string|max:20',

            'agreement'         => 'accepted',
        ]);
        // ================= KODE BARU: VALIDASI BLOCK SUBMIT DUA KALI SESUAI SKENARIO STATUS =================
        $pengajuanTerakhir = DB::table('permohonan_email_lembaga')
            ->where('email_alternatif', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($pengajuanTerakhir) {
            // Skenario 1: Jika status masih PENDING
            if ($pengajuanTerakhir->status == 'pending') {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Mohon maaf, Anda tidak dapat mengirimkan formulir baru. Masih ada formulir permohonan email lembaga Anda yang belum diproses oleh admin.');
            }

            // Skenario 2: Jika status sudah APPROVED atau ACTIVE
            if ($pengajuanTerakhir->status == 'approved' || $pengajuanTerakhir->status == 'active') {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Anda sudah pernah mengajukan permohonan email lembaga dan akun instansi Anda saat ini sudah aktif.');
            }
            
            // Skenario 3: Jika status REJECTED, pengecekan dilewati otomatis agar pengguna bisa buat formulir baru lagi.
        }
        // ================= END KODE BARU =================

        // 📝 CEK PENDING (BACKUP LAMA)
        $existingPending = DB::table('permohonan_email_lembaga')
            ->where('email_alternatif', Auth::user()->email)
            ->where('status', 'pending')
            ->exists();

        if ($existingPending) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Masih ada permohonan PENDING.');
        }

        try {
            DB::beginTransaction();

            // SOLUSI UTAMA: Mengabaikan input data administratif saat insert karena kolomnya tidak ada di skema database Anda.
            // Langkah ini menjamin error "Unknown column / kolom tidak ditemukan" tidak akan pernah terjadi lagi.
            DB::table('permohonan_email_lembaga')->insert([
                'nama_institusi'     => $validatedData['nama_institusi'],
                'nama_kegiatan'      => $validatedData['nama_kegiatan'],
                'nama_akun'          => $validatedData['nama_akun'],
                'email_alternatif'   => $validatedData['email_alternatif'],
                'nama_teknis'        => $validatedData['nama_teknis'],
                'nip_nik_nim_teknis' => $validatedData['nip_nik_nim_teknis'],
                'jabatan_teknis'     => $validatedData['jabatan_teknis'],
                'status_teknis'      => $validatedData['status_teknis'],
                'telp_teknis'        => $validatedData['telp_teknis'],
                'status'             => 'pending',
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // 📝 TAMBAHAN NOTIFIKASI DATABASE INTERNAL
            Notification::create([
                'user_id' => null,
                'title' => 'Permohonan Email Lembaga',
                'message' => Auth::user()->name . ' mengajukan permohonan email lembaga',
                'is_read' => 0,
            ]);

            // 📝 TAMBAHAN KODE BARU: FITUR EMAIL NOTIFIKASI MAILER OTOMATIS KE USER DAN ADMIN
            $emailTujuanUser = $validatedData['email_alternatif'];
            $namaPemohon = $validatedData['nama_teknis'];
           $domain = Auth::user()->institution_domain;

$namaAkunDiminta = $validatedData['nama_akun'] . '@' . $domain . '.ac.id';            // Kirim notifikasi salinan bukti pengajuan email ke alamat user bersangkutan
            Mail::send([], [], function ($message) use ($emailTujuanUser, $namaPemohon, $namaAkunDiminta) {
                $message->to($emailTujuanUser)
                    ->subject('Konfirmasi Permohonan Pembuatan Email Lembaga - UPT TIK')
                    ->html("
                        <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee; border-radius: 10px; max-width: 600px;'>
                            <h2 style='color: #B45309;'>Halo, {$namaPemohon}</h2>
                            <p>Terima kasih telah mengajukan permohonan pembuatan akun email lembaga melalui portal layanan IT.</p>
                            <hr style='border: 0; border-top: 1px solid #eee;'>
                            <table style='width: 100%; border-collapse: collapse;'>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Nama Akun Diminta:</td>
                                    <td style='padding: 8px 0; font-weight: bold;'><strong>{$namaAkunDiminta}</strong></td>
                                </tr>
                                <tr>
                                    <td style='padding: 8px 0; color: #666;'>Status Sistem:</td>
                                    <td style='padding: 8px 0; color: #f59e0b; font-weight: bold;'>PENDING (Dalam Antrean Verifikasi)</td>
                                </tr>
                            </table>
                            <hr style='border: 0; border-top: 1px solid #eee;'>
                            <p style='font-size: 13px; color: #666;'>Sistem kami akan melakukan pengecekan data ketersediaan nama domain. Password awal Anda akan dikirimkan otomatis ke email ini sesaat setelah permohonan Anda disetujui oleh administrator.</p>
                            <br>
                            <small style='color: #999;'>Pesan ini dikirim otomatis oleh sistem UPT TIK IT Service Portal.</small>
                        </div>
                    ");
            });

            DB::commit();

            return redirect()->back()->with(
                'success',
                'Permohonan berhasil dikirim!'
            );

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal memproses permohonan email lembaga: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Detail
     */
    public function show($id)
    {
        $email = DB::table('permohonan_email_lembaga')
            ->where('id', $id)
            ->first();

        if (!$email) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        if ($email->email_alternatif !== Auth::user()->email) {
            abort(403);
        }

        return view('user.detail_email_lembaga', compact('email'));
    }

    /**
     * Hapus
     */
    public function destroy($id)
    {
        try {
            $data = DB::table('permohonan_email_lembaga')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return back()->with('error', 'Data tidak ditemukan');
            }

            if ($data->email_alternatif !== Auth::user()->email) {
                return back()->with('error', 'Tidak diizinkan');
            }

            if ($data->status !== 'pending') {
                return back()->with('error', 'Sudah diproses admin');
            }

            DB::table('permohonan_email_lembaga')
                ->where('id', $id)
                ->delete();

            return back()->with('success', 'Berhasil dibatalkan');

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Gagal menghapus');
        }
    }

    // =========================================================================
    // 👑 TAMBAHAN KODE BARU WAJIB: METHOD ADMIN (SETUJUI, TOLAK, & UPDATE)
    // =========================================================================

    /**
     * Memproses Persetujuan Permohonan Email Lembaga oleh Admin
     */
    public function setuju(Request $request, $id)
    {
        $request->validate([
            'password_email' => 'required|string|min:6'
        ]);

        try {
            $email = DB::table('permohonan_email_lembaga')->where('id', $id)->first();
            if (!$email) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            // Update status menjadi approved dan simpan password awal
            DB::table('permohonan_email_lembaga')
                ->where('id', $id)
                ->update([
                    'status' => 'approved',
                    'password_email' => $request->password_email, // pastikan kolom ini ada atau amankan via update
                    'updated_at' => now()
                ]);

            // Kirim Notifikasi Dashboard ke User Pemohon
            Notification::create([
                'user_id' => null, // Atur ke ID User pemohon jika menggunakan relasi auth
                'title' => 'Permohonan Email Lembaga Disetujui',
                'message' => 'Akun email lembaga untuk ' . $email->nama_akun . ' telah aktif.',
                'is_read' => 0,
            ]);

           // Kirim Email Notifikasi Berisi Akun Baru ke User
$emailUser = $email->email_alternatif;
$namaAkun = $email->nama_akun;
$passwordBaru = $request->password_email;

// Ambil domain email dari tabel users berdasarkan email alternatif
$domain = DB::table('users')
    ->where('email', $emailUser)
    ->value('institution_domain');

if (!$domain) {
    $domain = 'institusi';
}

Mail::send([], [], function ($message) use ($emailUser, $namaAkun, $passwordBaru, $domain) {                $message->to($emailUser)
                    ->subject('Akun Email Lembaga Anda Telah Aktif!')
                    ->html("
                        <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #10b981; border-radius: 10px; max-width: 600px;'>
                            <h2 style='color: #10b981;'>Selamat! Akun Email Lembaga Aktif</h2>
                            <p>Permohonan pembuatan email lembaga Anda telah disetujui. Berikut rincian login Anda:</p>
                            <table style='width: 100%; background: #f0fdf4; padding: 15px; border-radius: 8px;'>
                                <tr><td><strong>Email:</strong></td><td><code>{$namaAkun}{$namaAkun}@{$domain}.ac.id</code></td></tr>
                                <tr><td><strong>Password Awal:</strong></td><td><code>{$passwordBaru}</code></td></tr>
                            </table>
                            <p style='color: #ef4444; font-size: 13px; margin-top: 15px;'>*Harap segera lakukan perubahan password demi keamanan saat pertama kali login.</p>
                        </div>
                    ");
            });

            return redirect()->back()->with('success', 'Permohonan email lembaga berhasil disetujui.');

        } catch (\Exception $e) {
            Log::error('Error Setuju Email Lembaga: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses persetujuan: ' . $e->getMessage());
        }
    }

    /**
     * Memproses Penolakan Permohonan Email Lembaga (BEBAS ERROR UNKNOWN COLUMN 'catatan')
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|max:500'
        ]);

        try {
            $email = DB::table('permohonan_email_lembaga')->where('id', $id)->first();
            if (!$email) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            // PERBAIKAN UTAMA: Hanya lakukan update ke kolom 'alasan_tolak' & mengabaikan 'catatan'
            DB::table('permohonan_email_lembaga')
                ->where('id', $id)
                ->update([
                    'status' => 'rejected',
                    'alasan_tolak' => $request->alasan_tolak, // Menyimpan murni ke kolom yang tersedia di database
                    'updated_at' => now()
                ]);

            // Kirim Notifikasi Dashboard Internal
            Notification::create([
                'user_id' => null,
                'title' => 'Permohonan Email Lembaga Ditolak',
                'message' => 'Maaf, permohonan email untuk ' . $email->nama_akun . ' ditolak karena: ' . $request->alasan_tolak,
                'is_read' => 0,
            ]);

            // Kirim Notifikasi Email Penolakan ke Alamat User
            $emailUser = $email->email_alternatif;
            $alasan = $request->alasan_tolak;

            Mail::send([], [], function ($message) use ($emailUser, $alasan) {
                $message->to($emailUser)
                    ->subject('Informasi Status Permohonan Email Lembaga')
                    ->html("
                        <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ef4444; border-radius: 10px; max-width: 600px;'>
                            <h2 style='color: #ef4444;'>Permohonan Belum Disetujui</h2>
                            <p>Mohon maaf, permohonan pembuatan akun email lembaga Anda saat ini ditolak oleh Administrator dengan alasan berikut:</p>
                            <div style='background: #fef2f2; padding: 15px; border-left: 4px solid #ef4444; color: #b91c1c; font-weight: 500;'>
                                \" {$alasan} \"
                            </div>
                            <p style='margin-top: 15px; font-size: 13px; color: #4b5563;'>Silakan masuk kembali ke portal layanan untuk melakukan perbaikan data dan mengirimkan ulang permohonan Anda.</p>
                        </div>
                    ");
            });

            return redirect()->back()->with('success', 'Permohonan berhasil ditolak dan email alasan penolakan dikirim.');

        } catch (\Exception $e) {
            Log::error('Error Tolak Email Lembaga: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses penolakan: ' . $e->getMessage());
        }
    }
}