<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Pastikan nama model ini ada di folder app/Models/
use App\Models\PermohonanEmail; 
use App\Models\EmailLembaga;
use App\Models\PermohonanEmailPribadi;
use App\Models\AkunEmailPribadi;
use App\Models\Notification; // Menggunakan model ini untuk log notifikasi internal database
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Digunakan untuk manipulasi tanggal

class EmailAdminController extends Controller
{
    /* =====================================================
     * LIST SEMUA PERMOHONAN
     * ===================================================== */
   public function index()
{
    try {
        return view('admin.kelolaemail', [
            'emailPribadi' => DB::table('permohonan_email_pribadi')
                                ->orderBy('created_at', 'desc')
                                ->get(),

            'emailLembaga' => DB::table('permohonan_email_lembaga')
                                ->orderBy('created_at', 'desc')
                                ->get(),
        ]);
    } catch (\Exception $e) {
        Log::error("Error Index Admin: " . $e->getMessage());
        return back()->with('error', 'Gagal memuat data permohonan.');
    }
}
    /* =====================================================
     * DETAIL EMAIL LEMBAGA ✅ FIXED DATE FORMAT ERROR
     * ===================================================== */
    public function detailLembaga($id)
    {
        // Menggunakan DB table agar lebih aman dari error "Class Not Found"
        $email = DB::table('permohonan_email_lembaga')->where('id', $id)->first();
        
        if (!$email) {
            return redirect()->route('admin.kelolaemail')->with('error', 'Data tidak ditemukan.');
        }

        /** * FIX: Konversi string updated_at dan created_at menjadi Objek Carbon
         * Agar di Blade bisa memanggil fungsi ->format() tanpa error 500
         */
        if (isset($email->updated_at)) {
            $email->updated_at = Carbon::parse($email->updated_at);
        }
        if (isset($email->created_at)) {
            $email->created_at = Carbon::parse($email->created_at);
        }
        
        // Ambil data akun aktif dari tabel emails_lembaga berdasarkan email pemohon
        $akunAktif = DB::table('emails_lembaga')->where('email_pemohon', $email->email_alternatif)->first();

        // Kirim kedua data ke view
        return view('admin.emaillembaga', compact('email', 'akunAktif'));
    }

    /* =====================================================
     * DETAIL EMAIL PRIBADI ✅ FIXED TABLE NAME ERROR
     * ===================================================== */
    public function detailPribadi($id)
    {
        // Menggunakan DB table menunjuk ke nama tabel permohonan_email_pribadi yang benar
        $email = DB::table('permohonan_email_pribadi')->where('id', $id)->first();
        
        if (!$email) {
            return redirect()->route('admin.kelolaemail')->with('error', 'Data tidak ditemukan.');
        }

        if (isset($email->updated_at)) {
            $email->updated_at = Carbon::parse($email->updated_at);
        }
        if (isset($email->created_at)) {
            $email->created_at = Carbon::parse($email->created_at);
        }

        /**
         * FIX: Mengubah akuns_email_pribadi menjadi akun_email_pribadi
         * untuk mencocokkan dengan nama tabel yang ada di database Anda.
         */
        $akunAktif = DB::table('akun_email_pribadi')->where('permohonan_id', $id)->first();

        // Jembatan pengamanan data dipertahankan jika dipanggil di view
        if ($email && !isset($email->alasan_tolak) && isset($email->catatan)) {
            $email->alasan_tolak = $email->catatan;
        }

        // Kirim data permohonan ($email) and akunAktif ke view
        return view('admin.EmailPribadi', compact('email', 'akunAktif'));
    }

    /* =====================================================
     * SETUJU EMAIL LEMBAGA ✅ FIX & LENGKAPI EMAIL NOTIFIKASI DIRECT HTML
     * ===================================================== */
    public function setujuLembaga(Request $request, $id)
    {
        $request->validate([
            'jenis_akun' => 'required|string',
            'nama_akun'  => 'required|string|max:100',
            'password'   => 'required|string|min:8',
        ]);

        try {
            // Membuat variabel penampung nama institusi untuk session message di luar closure transaction
            $namaInstitusiLog = '';

            DB::transaction(function () use ($request, $id, &$namaInstitusiLog) {
                $permohonan = DB::table('permohonan_email_lembaga')->where('id', $id)->first();

                if (!$permohonan) throw new \Exception("Data permohonan tidak ditemukan.");
                
                $namaInstitusiLog = $permohonan->nama_institusi;

                // 1. Simpan ke tabel akun lembaga yang aktif (emails_lembaga)
                DB::table('emails_lembaga')->insert([
                    'jenis_akun'    => $request->jenis_akun,
                    'nama_akun'     => $request->nama_akun,
                    'password_hash' => Hash::make($request->password),
                    'email_pemohon' => $permohonan->email_alternatif,
                    'status'        => 'disetujui',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                // 2. Update status di tabel permohonan
                DB::table('permohonan_email_lembaga')->where('id', $id)->update([
                    'status' => 'disetujui',
                    'updated_at' => now(),
                ]);

                // 3. Kirim Email Notifikasi Lengkap Secara Direct HTML (Anti-Error View Not Found)
                $emailTujuan = $permohonan->email_alternatif;
                $namaInstitusi = $permohonan->nama_institusi;
                $akunEmailBaru = $request->nama_akun;
                $passwordBaru = $request->password;
                $jenisAkun = $request->jenis_akun;

                $htmlContent = "
                    <div style='font-family: Arial, sans-serif; padding: 25px; border: 1px solid #e0e0e0; border-radius: 12px; max-width: 600px; margin: 0 auto; background-color: #ffffff;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <h2 style='color: #10B981; margin: 0;'>Permohonan Disetujui</h2>
                            <p style='color: #6B7280; font-size: 14px;'>UPT TIK IT Service Portal</p>
                        </div>
                        <p>Halo Pengelola <strong>{$namaInstitusi}</strong>,</p>
                        <p>Permohonan pembuatan akun email lembaga yang Anda ajukan telah diverifikasi dan **DISETUJUI** oleh Administrator Sistem.</p>
                        
                        <div style='background-color: #F3F4F6; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                            <h4 style='margin-top: 0; color: #374151; border-bottom: 1px solid #E5E7EB; padding-bottom: 5px;'>Detail Akun Baru:</h4>
                            <table style='width: 100%; font-size: 14px;'>
                                <tr>
                                    <td style='padding: 5px 0; color: #4B5563; width: 35%;'>Jenis Akun:</td>
                                    <td style='padding: 5px 0; font-weight: bold; color: #1F2937;'>{$jenisAkun}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 5px 0; color: #4B5563;'>Alamat Email:</td>
                                    <td style='padding: 5px 0; font-weight: bold; color: #2563EB;'>{$akunEmailBaru}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 5px 0; color: #4B5563;'>Password Awal:</td>
                                    <td style='padding: 5px 0; font-family: monospace; font-size: 15px; color: #EF4444; font-weight: bold;'>{$passwordBaru}</td>
                                </tr>
                            </table>
                        </div>

                        <p style='font-size: 13px; color: #4B5563; line-height: 1.5;'>
                            *Keamanan Informasi:* Demi menjaga keamanan data institusi, mohon segera melakukan perubahan password default saat pertama kali Anda melakukan login ke layanan webmail resmi.
                        </p>
                        <hr style='border: 0; border-top: 1px solid #E5E7EB; margin: 20px 0;'>
                        <p style='font-size: 12px; color: #9CA3AF; text-align: center; margin: 0;'>Pesan otomatis. Harap jangan membalas email ini secara langsung.</p>
                    </div>
                ";

                Mail::send([], [], function ($message) use ($emailTujuan, $htmlContent) {
                    $message->to($emailTujuan)
                            ->subject('Selamat! Akun Email Lembaga Anda Telah Aktif')
                            ->html($htmlContent);
                });

                // 4. LENGKAPI: Rekam log notifikasi sukses ke dalam internal database sistem
                try {
                    DB::table('notifications')->insert([
                        'title' => 'Permohonan Email Lembaga Disetujui',
                        'message' => "Akun email lembaga untuk {$namaInstitusi} ({$akunEmailBaru}) berhasil diaktifkan.",
                        'type' => 'success',
                        'user_id' => auth()->id() ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } catch (\Exception $ne) {
                    Log::warning("Gagal mencatat notifikasi DB (Setuju Lembaga): " . $ne->getMessage());
                }
            });

            return redirect()->route('admin.kelolaemail')->with('success', 'Permohonan email lembaga untuk "' . $namaInstitusiLog . '" berhasil disetujui dan email notifikasi telah dikirim.');

        } catch (\Exception $e) {
            Log::error("Error Setuju Lembaga: " . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * TOLAK EMAIL LEMBAGA ✅ LENGKAPI NOTIFIKASI DIRECT HTML
     * ===================================================== */
    public function tolakLembaga(Request $request, $id)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|min:5',
        ]);

        try {
            $permohonan = DB::table('permohonan_email_lembaga')->where('id', $id)->first();

            if (!$permohonan) return back()->with('error', 'Data tidak ditemukan.');

            // Untuk lembaga tetap mempertahankan catatan & alasan_tolak jika kolomnya memang tersedia dualisme di tabel tersebut
            DB::table('permohonan_email_lembaga')->where('id', $id)->update([
                'status'       => 'ditolak', 
                'catatan'      => $request->alasan_tolak,
                'alasan_tolak' => $request->alasan_tolak,
                'updated_at'   => now(),
            ]);

            // Pengiriman Notifikasi Penolakan Direct HTML
            $emailTujuan = $permohonan->email_alternatif;
            $namaInstitusi = $permohonan->nama_institusi;
            $alasanTolak = $request->alasan_tolak;

            $htmlContent = "
                <div style='font-family: Arial, sans-serif; padding: 25px; border: 1px solid #e0e0e0; border-radius: 12px; max-width: 600px; margin: 0 auto; background-color: #ffffff;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                        <h2 style='color: #EF4444; margin: 0;'>Permohonan Ditolak</h2>
                        <p style='color: #6B7280; font-size: 14px;'>UPT TIK IT Service Portal</p>
                    </div>
                    <p>Halo Pengelola <strong>{$namaInstitusi}</strong>,</p>
                    <p>Kami menginformasikan bahwa pengajuan akun email lembaga Anda saat ini **BELUM DAPAT DISETUJUI** oleh Administrator.</p>
                    
                    <div style='background-color: #FEF2F2; border-left: 4px solid #EF4444; padding: 15px; border-radius: 4px; margin: 20px 0;'>
                        <h4 style='margin-top: 0; color: #991B1B;'>Catatan / Alasan Penolakan:</h4>
                        <p style='color: #7F1D1D; font-size: 14px; margin: 0;'>\"{$alasanTolak}\"</p>
                    </div>

                    <p style='font-size: 13px; color: #4B5563;'>
                        Silakan lakukan perbaikan berkas kriteria pengisian data atau hubungi bagian helpdesk UPT TIK jika dirasa ada kekeliruan data penolakan. Anda dapat mengajukan permohonan baru kembali setelah status permohonan dibersihkan oleh sistem.
                    </p>
                    <hr style='border: 0; border-top: 1px solid #E5E7EB; margin: 20px 0;'>
                    <p style='font-size: 12px; color: #9CA3AF; text-align: center; margin: 0;'>Pesan otomatis. Harap jangan membalas email ini secara langsung.</p>
                </div>
            ";

            Mail::send([], [], function ($message) use ($emailTujuan, $htmlContent) {
                $message->to($emailTujuan)
                        ->subject('Informasi Penolakan Permohonan Email Lembaga')
                        ->html($htmlContent);
            });

            // LENGKAPI: Rekam log notifikasi penolakan ke internal database sistem menggunakan DB table agar anti-crash
            try {
                DB::table('notifications')->insert([
                    'title' => 'Permohonan Email Lembaga Ditolak',
                    'message' => "Permohonan email lembaga untuk {$namaInstitusi} ditolak dengan alasan: {$alasanTolak}",
                    'type' => 'danger',
                    'user_id' => auth()->id() ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } catch (\Exception $ne) {
                Log::warning("Gagal mencatat notifikasi DB (Tolak Lembaga): " . $ne->getMessage());
            }

            return redirect()->route('admin.kelolaemail')->with('success', 'Permohonan email lembaga untuk "' . $namaInstitusi . '" berhasil ditolak dan notifikasi resmi telah dikirim.');

        } catch (\Exception $e) {
            Log::error("Error Tolak Lembaga: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menolak: Pastikan kolom alasan_tolak sudah ada di database. Detail: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * SETUJU EMAIL PRIBADI ✅ FIXED & EMAIL OPTIMIZED
     * ===================================================== */
    public function setujuPribadi(Request $request, $id)
    {
        $request->validate([
            'nama_akun' => 'required|string|max:100',
            'password'  => 'required|string|min:8',
        ]);

        try {
            $namaLengkapLog = '';

            DB::transaction(function () use ($request, $id, &$namaLengkapLog) {
                $permohonan = DB::table('permohonan_email_pribadi')->where('id', $id)->first();

                if (!$permohonan) throw new \Exception("Data permohonan tidak ditemukan.");

                $namaLengkapLog = $permohonan->nama_lengkap ?? ($permohonan->nama_pribadi ?? 'Civitas Academic');

                // Ambil text input murni dari user, tambahkan domain utama institusi secara otomatis
                $akunEmailBaruMurni = trim($request->nama_akun);
                $domainKonektor = '@institusi.ac.id';
                
                // Mencegah penumpukan jika user tidak sengaja mengetikkan domain secara manual di form
                if (str_contains($akunEmailBaruMurni, $domainKonektor)) {
                    $akunFinalDatabase = $akunEmailBaruMurni;
                } else {
                    $akunFinalDatabase = $akunEmailBaruMurni . $domainKonektor;
                }

                // FIX: Menggunakan nama tabel tunggal 'akun_email_pribadi'
                DB::table('akun_email_pribadi')->insert([
                    'permohonan_id' => $permohonan->id,
                    'nama_akun'     => str_replace($domainKonektor, '', $akunFinalDatabase), // Menyimpan nama akun murni di kolom DB
                    'password'      => Hash::make($request->password),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                DB::table('permohonan_email_pribadi')->where('id', $id)->update([
                    'status'     => 'disetujui',
                    'updated_at' => now(),
                ]);

                // Pengiriman Notifikasi Persetujuan Akun Pribadi Direct HTML
                $emailTujuan = $permohonan->email_alternatif;
                $namaLengkap = $namaLengkapLog;
                $passwordBaru = $request->password;

                $htmlContent = "
                    <div style='font-family: Arial, sans-serif; padding: 25px; border: 1px solid #e0e0e0; border-radius: 12px; max-width: 600px; margin: 0 auto; background-color: #ffffff;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <h2 style='color: #10B981; margin: 0;'>Akun Pribadi Aktif</h2>
                            <p style='color: #6B7280; font-size: 14px;'>UPT TIK IT Service Portal</p>
                        </div>
                        <p>Halo <strong>{$namaLengkap}</strong>,</p>
                        <p>Selamat, pengajuan kepemilikan akun email civitas akademik pribadi Anda resmi **DISETUJUI** and telah dikonfigurasi.</p>
                        
                        <div style='background-color: #F3F4F6; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                            <h4 style='margin-top: 0; color: #374151; border-bottom: 1px solid #E5E7EB; padding-bottom: 5px;'>Detail Kredensial Login:</h4>
                            <table style='width: 100%; font-size: 14px;'>
                                <tr>
                                    <td style='padding: 5px 0; color: #4B5563; width: 35%;'>Alamat Email:</td>
                                    <td style='padding: 5px 0; font-weight: bold; color: #2563EB;'>{$akunFinalDatabase}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 5px 0; color: #4B5563;'>Password Default:</td>
                                    <td style='padding: 5px 0; font-family: monospace; font-size: 15px; color: #EF4444; font-weight: bold;'>{$passwordBaru}</td>
                                </tr>
                            </table>
                        </div>

                        <p style='font-size: 13px; color: #4B5563;'>
                            Gunakan akun ini secara bijak demi mendukung kelancaran kegiatan tri dharma perguruan tinggi. Segera ubah kata sandi bawaan demi keamanan optimal.
                        </p>
                        <hr style='border: 0; border-top: 1px solid #E5E7EB; margin: 20px 0;'>
                        <p style='font-size: 12px; color: #9CA3AF; text-align: center; margin: 0;'>Pesan otomatis. Harap jangan membalas email ini secara langsung.</p>
                    </div>
                ";

                Mail::send([], [], function ($message) use ($emailTujuan, $htmlContent) {
                    $message->to($emailTujuan)
                            ->subject('Akun Email Pribadi Institusi Anda Telah Aktif')
                            ->html($htmlContent);
                });

                // LENGKAPI: Rekam log notifikasi sukses menggunakan DB Builder biasa agar terhindar dari mass-assignment guard
                try {
                    DB::table('notifications')->insert([
                        'title' => 'Permohonan Email Pribadi Disetujui',
                        'message' => "Akun email pribadi atas nama {$namaLengkap} ({$akunFinalDatabase}) berhasil diaktifkan.",
                        'type' => 'success',
                        'user_id' => auth()->id() ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } catch (\Exception $ne) {
                    Log::warning("Gagal mencatat notifikasi DB (Setuju Pribadi): " . $ne->getMessage());
                }
            });

            return redirect()->route('admin.kelolaemail')->with('success', 'Permohonan email pribadi atas nama "' . $namaLengkapLog . '" berhasil disetujui.');

        } catch (\Exception $e) {
            Log::error("Error Setuju Pribadi: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * TOLAK EMAIL PRIBADI ✅ FIX: PEMBERSIHAN QUERY KOLOM 'CATATAN'
     * ===================================================== */
    public function tolakPribadi(Request $request, $id)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|min:5',
        ], [
            'alasan_tolak.required' => 'Alasan penolakan wajib diisi.',
            'alasan_tolak.min' => 'Alasan penolakan minimal berisi 5 karakter.'
        ]);

        try {
            $permohonan = DB::table('permohonan_email_pribadi')->where('id', $id)->first();

            if (!$permohonan) {
                return redirect()->route('admin.kelolaemail')->with('error', 'Data tidak ditemukan.');
            }

            // PERBAIKAN UTAMA: Kolom 'catatan' resmi dihapus dari array update karena tidak ada di tabel database pribadi Anda.
            DB::table('permohonan_email_pribadi')->where('id', $id)->update([
                'status'       => 'ditolak',
                'alasan_tolak' => $request->alasan_tolak, 
                'updated_at'   => now(),
            ]);

            // Pengiriman Notifikasi Penolakan Akun Pribadi Direct HTML
            $emailTujuan = $permohonan->email_alternatif;
            $namaLengkap = $permohonan->nama_lengkap ?? ($permohonan->nama_pribadi ?? 'Civitas Academic');
            $alasanTolak = $request->alasan_tolak;

            $htmlContent = "
                <div style='font-family: Arial, sans-serif; padding: 25px; border: 1px solid #e0e0e0; border-radius: 12px; max-width: 600px; margin: 0 auto; background-color: #ffffff;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                        <h2 style='color: #EF4444; margin: 0;'>Permohonan Ditolak</h2>
                        <p style='color: #6B7280; font-size: 14px;'>UPT TIK IT Service Portal</p>
                    </div>
                    <p>Halo <strong>{$namaLengkap}</strong>,</p>
                    <p>Kami menginformasikan bahwa pengajuan akun email pribadi civitas akademik yang Anda ajukan **BELUM DAPAT DISETUJUI** oleh Administrator Sistem.</p>
                    
                    <div style='background-color: #FEF2F2; border-left: 4px solid #EF4444; padding: 15px; border-radius: 4px; margin: 20px 0;'>
                        <h4 style='margin-top: 0; color: #991B1B;'>Alasan Penolakan:</h4>
                        <p style='color: #7F1D1D; font-size: 14px; margin: 0;'>\"{$alasanTolak}\"</p>
                    </div>

                    <p style='font-size: 13px; color: #4B5563;'>
                        Mohon periksa kembali keselarasan ID Identitas Resmi (NIP/NIM) Anda dengan database kepegawaian atau kemahasiswaan. Silakan ajukan ulang form setelah melakukan perbaikan data.
                    </p>
                    <hr style='border: 0; border-top: 1px solid #E5E7EB; margin: 20px 0;'>
                    <p style='font-size: 12px; color: #9CA3AF; text-align: center; margin: 0;'>Pesan otomatis. Harap jangan membalas email ini secara langsung.</p>
                </div>
            ";

            // Gunakan try-catch lokal khusus Mail agar jika server email mati, proses DB tetap tersimpan dan tidak crash kosong
            try {
                Mail::send([], [], function ($message) use ($emailTujuan, $htmlContent) {
                    $message->to($emailTujuan)
                            ->subject('Informasi Penolakan Permohonan Email Pribadi')
                            ->html($htmlContent);
                });
            } catch (\Exception $me) {
                Log::error("Gagal mengirim email penolakan pribadi: " . $me->getMessage());
            }

            // FIX UTAMA: Menggunakan DB::table agar jika model Notification.php bermasalah, codingan utama TIDAK CRASH.
            try {
                DB::table('notifications')->insert([
                    'title' => 'Permohonan Email Pribadi Ditolak',
                    'message' => "Permohonan email pribadi atas nama {$namaLengkap} ditolak dengan alasan: {$alasanTolak}",
                    'type' => 'danger',
                    'user_id' => auth()->id() ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } catch (\Exception $ne) {
                Log::warning("Gagal mencatat log internal notification (Tolak Pribadi): " . $ne->getMessage());
            }

            // FIX REDIRECT: Diubah mengarah ke halaman utama dashboard/kelola email dengan membawa pesan sukses penolakan
            return redirect()->route('admin.kelolaemail')->with('success', 'Permohonan email pribadi atas nama "' . $namaLengkap . '" berhasil ditolak.');
            
        } catch (\Exception $e) {
            Log::error("Error Tolak Pribadi: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memproses penolakan: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * HAPUS EMAIL LEMBAGA
     * ===================================================== */
    public function destroyLembaga($id)
    {
        try {
            $email = DB::table('permohonan_email_lembaga')->where('id', $id)->first();
            
            if ($email) {
                DB::table('emails_lembaga')->where('email_pemohon', $email->email_alternatif)->delete();
                DB::table('permohonan_email_lembaga')->where('id', $id)->delete();
                return back()->with('success', 'Permohonan email lembaga berhasil dihapus.');
            }
            
            return back()->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * HAPUS EMAIL PRIBADI ✅ FIXED TABLE NAME ERROR
     * ===================================================== */
    public function destroyPribadi($id)
    {
        try {
            $email = DB::table('permohonan_email_pribadi')->where('id', $id)->first();
            if ($email) {
                // FIX: Menggunakan nama tabel tunggal 'akun_email_pribadi'
                DB::table('akun_email_pribadi')->where('permohonan_id', $id)->delete();
                DB::table('permohonan_email_pribadi')->where('id', $id)->delete();

                return back()->with('success', 'Permohonan email pribadi berhasil dihapus.');
            }
            return back()->with('error', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}