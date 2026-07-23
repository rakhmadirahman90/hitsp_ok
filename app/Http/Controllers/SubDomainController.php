<?php

namespace App\Http\Controllers;

use App\Models\SubDomain;
use App\Models\Notification; // ?? TAMBAHAN
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Tambahan untuk fitur kirim email
use Illuminate\Support\Facades\Log;  // Tambahan untuk logging error jika kirim email gagal
use Illuminate\Support\Facades\Validator; // Tambahan untuk meredam auto-redirect validasi bermasalah

class SubDomainController extends Controller
{
    public function create()
    {
        return view('user.reqdomain');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_domain' => 'required|string',
            'nama_organisasi' => 'required|string|max:255',

            'nama_admin' => 'required|string|max:255',
            'nip_admin' => 'required|string|max:50',
            'alamat_kantor_admin' => 'required|string',
            'alamat_rumah_admin' => 'required|string',
            'telp_kantor_admin' => 'required|string|max:20',
            'telp_rumah_admin' => 'required|string|max:20',
            'email_admin' => 'required|email',

            'nama_teknis' => 'required|string|max:255',
            'nip_nim_teknis' => 'required|string|max:50',
            'alamat_kantor_teknis' => 'required|string',
            'alamat_rumah_teknis' => 'required|string',
            'telp_kantor_teknis' => 'required|string|max:20',
            'email_teknis' => 'required|email',

            'nama_sub_domain' => 'required|string|max:255|unique:sub_domains,nama_sub_domain',
        ]);

        // =====================
        // SIMPAN SUBDOMAIN
        // =====================
        SubDomain::create([
            'user_id' => Auth::id(),

            'jenis_domain' => $request->jenis_domain,
            'nama_organisasi' => $request->nama_organisasi,

            'nama_admin' => $request->nama_admin,
            'nip_admin' => $request->nip_admin,
            'alamat_kantor_admin' => $request->alamat_kantor_admin,
            'alamat_rumah_admin' => $request->alamat_rumah_admin,
            'telp_kantor_admin' => $request->telp_kantor_admin,
            'telp_rumah_admin' => $request->telp_rumah_admin,
            'email_admin' => $request->email_admin,

            'nama_teknis' => $request->nama_teknis,
            'nip_nim_teknis' => $request->nip_nim_teknis,
            'alamat_kantor_teknis' => $request->alamat_kantor_teknis,
            'alamat_rumah_teknis' => $request->alamat_rumah_teknis,
            'telp_kantor_teknis' => $request->telp_kantor_teknis,
            'email_teknis' => $request->email_teknis,

            'nama_sub_domain' => $request->nama_sub_domain,

            'status' => 'pending',
        ]);

        // =====================
        // ?? NOTIFIKASI ADMIN
        // =====================
        Notification::create([
            'user_id' => null,
            'title' => 'Permintaan Subdomain Baru',
            'message' => Auth::user()->name . ' mengajukan request subdomain: ' . $request->nama_sub_domain,
            'is_read' => 0,
        ]);

        return redirect()->back()->with('success', 'Permohonan subdomain berhasil dikirim!');
    }

    public function index()
    {
        $subDomains = SubDomain::where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('user.daftardomain', compact('subDomains'));
    }

    // =========================================================================
    // ?? KODE BARU TAMBAHAN: DETAIL, SETUJUI, & TOLAK (SAMA SEPERTI LAYANAN LAIN)
    // =========================================================================

    /**
     * Menampilkan Detail Permohonan Subdomain (Untuk Admin / User)
     */
    public function show($id)
    {
        // PERBAIKAN: Eager load relasi hostingAccess agar data pabean terikat sempurna saat dipanggil di Blade
        $subdomain = SubDomain::with('hostingAccess')->findOrFail($id);
        
        // ?? PENAMBAHAN SISTEM DEKRIPSI OTOMATIS: Agar password tampil utuh (plain-text) di dalam Modal Edit & Halaman Show
        if ($subdomain->hostingAccess) {
            try {
                if ($subdomain->hostingAccess->ssh_password) {
                    $subdomain->hostingAccess->ssh_password = decrypt($subdomain->hostingAccess->ssh_password);
                }
            } catch (\Exception $e) {}

            try {
                if ($subdomain->hostingAccess->db_password) {
                    $subdomain->hostingAccess->db_password = decrypt($subdomain->hostingAccess->db_password);
                }
            } catch (\Exception $e) {}
        }

        try {
            if ($subdomain->ssh_password) $subdomain->ssh_password = decrypt($subdomain->ssh_password);
            if ($subdomain->db_password) $subdomain->db_password = decrypt($subdomain->db_password);
        } catch (\Exception $e) {}

        // ?? PERBAIKAN UTAMA MODAL KOSONG: Deteksi jika request diklik via Tombol Edit/AJAX, lempar response berupa JSON data utuh
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $subdomain
            ]);
        }
        
        // Menggunakan view yang disesuaikan dengan dashboard Anda, misal: 'admin.detaildomain'
        return view('admin.detaildomain', compact('subdomain'));
    }

    /**
     * Memproses Persetujuan Permohonan Subdomain oleh Admin
     */
    public function setuju(Request $request, $id)
    {
        $subdomain = SubDomain::findOrFail($id);
        
        try {
            // =====================================================================================
            // PERBAIKAN PROTEKSI VALIDASI: Menyertakan Password SSH & Database Password secara Lengkap
            // =====================================================================================
            $validator = Validator::make($request->all(), [
                'ip_server'    => 'required|string|max:255',
                'ssh_user'     => 'required|string|max:255',
                'ssh_password' => 'required|string|max:255', // Lengkap sesuai gambar
                'db_name'      => 'required|string|max:255',
                'db_user'      => 'required|string|max:255',
                'db_password'  => 'required|string|max:255', // Lengkap sesuai gambar
                'app_path'     => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Gagal menyetujui: ' . $validator->errors()->first());
            }

            // ?? SISTEM PROTEKSI KEAMANAN DATA: Enkripsi password sebelum disimpan ke database
            $encryptedSsh = encrypt($request->ssh_password);
            $encryptedDb = encrypt($request->db_password);

            // 1. Update status subdomain menjadi approved beserta data field hosting langsung ke tabel sub_domains
            $subdomain->update([
                'status'       => 'approved', 
                'ip_server'    => $request->ip_server,
                'ssh_user'     => $request->ssh_user,
                'ssh_password' => $encryptedSsh,
                'db_name'      => $request->db_name,
                'db_user'      => $request->db_user,
                'db_password'  => $encryptedDb,
                'app_path'     => $request->app_path,
                'updated_at'   => now()
            ]);

            // =========================================================================
            // PERBAIKAN PENYIMPANAN: Sinkronisasi data ke tabel relasi 'hosting_access'
            // =========================================================================
            if (method_exists($subdomain, 'hostingAccess')) {
                $subdomain->hostingAccess()->updateOrCreate(
                    ['sub_domain_id' => $subdomain->id],
                    [
                        'ip_server'    => $request->ip_server,
                        'ssh_user'     => $request->ssh_user,
                        'ssh_password' => $encryptedSsh,
                        'db_name'      => $request->db_name,
                        'db_user'      => $request->db_user,
                        'db_password'  => $encryptedDb,
                        'app_path'     => $request->app_path,
                    ]
                );
            }

            // 2. Buat Notifikasi Dashboard Sistem untuk User Pemohon
            Notification::create([
                'user_id' => $subdomain->user_id,
                'title' => 'Permohonan Subdomain Disetujui',
                'message' => 'Selamat! Pengajuan subdomain ' . $subdomain->nama_sub_domain . ' Anda telah aktif dan disetujui oleh Admin.',
                'is_read' => 0,
            ]);

            // 3. Kirim Notifikasi Email ke Email Admin Pemohon
            $emailTujuan = $subdomain->email_admin; 
            $dataEmail = [
                'nama_pemohon' => $subdomain->nama_admin,
                'subdomain'    => $subdomain->nama_sub_domain,
                'status'       => 'APPROVED',
                'keterangan'   => 'Subdomain Anda sudah dikonfigurasi dan saat ini sudah dapat diakses secara penuh.',
                // Penambahan data credential hosting pada email agar terkirim sempurna ke pemohon
                'ip_server'    => $request->ip_server,
                'ssh_user'     => $request->ssh_user,
                'ssh_password' => $request->ssh_password,
                'db_name'      => $request->db_name,
                'db_user'      => $request->db_user,
                'db_password'  => $request->db_password,
                'app_path'     => $request->app_path,
            ];

            Mail::send('emails.subdomain_status', $dataEmail, function($message) use ($emailTujuan, $subdomain) {
                $message->to($emailTujuan)
                        ->subject('Informasi Aktivasi Subdomain: ' . $subdomain->nama_sub_domain);
            });

            return redirect()->back()->with('success', 'Permohonan subdomain berhasil disetujui dan email notifikasi telah dikirim.');

        } catch (\Exception $e) {
            Log::error("Error Setuju Subdomain: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses persetujuan: ' . $e->getMessage());
        }
    }

    /**
     * Memproses Penolakan Permohonan Subdomain oleh Admin
     */
    public function tolak(Request $request, $id)
    {
        // Validasi input alasan penolakan wajib diisi menggunakan Validator manual agar aman
        $validator = Validator::make($request->all(), [
            'alasan_tolak' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        $subdomain = SubDomain::findOrFail($id);

        try {
            // 1. Update status subdomain menjadi rejected beserta alasannya ke kolom alasan_tolak
            $subdomain->update([
                'status' => 'rejected',
                'alasan_tolak' => $request->alasan_tolak, 
                'updated_at' => now()
            ]);

            // 2. Buat Notifikasi Dashboard Sistem untuk User Pemohon
            Notification::create([
                'user_id' => $subdomain->user_id,
                'title' => 'Permohonan Subdomain Ditolak',
                'message' => 'Maaf, pengajuan subdomain ' . $subdomain->nama_sub_domain . ' Anda ditolak. Alasan: ' . $request->alasan_tolak,
                'is_read' => 0,
            ]);

            // 3. Kirim Notifikasi Email Penolakan ke User Pemohon
            $emailTujuan = $subdomain->email_admin;
            $dataEmail = [
                'nama_pemohon' => $subdomain->nama_admin,
                'subdomain'    => $subdomain->nama_sub_domain,
                'status'       => 'REJECTED',
                'keterangan'   => $request->alasan_tolak
            ];

            Mail::send('emails.subdomain_status', $dataEmail, function($message) use ($emailTujuan, $subdomain) {
                $message->to($emailTujuan)
                        ->subject('Informasi Penolakan Subdomain: ' . $subdomain->nama_sub_domain);
            });

            return redirect()->back()->with('success', 'Permohonan subdomain telah ditolak dan email pemberitahuan telah dikirim.');

        } catch (\Exception $e) {
            Log::error("Error Tolak Subdomain: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses penolakan: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // ?? KODE BARU WAJIB: UPDATE PARAMETER KONFIGURASI HOSTING (AKSES SERVER)
    // =========================================================================
    /**
     * Memperbarui Parameter Hosting Ketika Status Approved / Active / Disabled
     */
    public function updateHosting(Request $request, $id)
    {
        $subdomain = SubDomain::findOrFail($id);

        // Validasi parameter input edit dengan Validator manual
        $validator = Validator::make($request->all(), [
            'ip_server'    => 'required|string|max:255',
            'ssh_user'     => 'required|string|max:255',
            'ssh_password' => 'required|string|max:255', // Lengkap sesuai gambar
            'db_name'      => 'required|string|max:255',
            'db_user'      => 'required|string|max:255',
            'db_password'  => 'required|string|max:255', // Lengkap sesuai gambar
            'app_path'     => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $validator->errors()->first());
        }

        try {
            // ?? ENKRIPSI KEAMANAN DATA: Enkripsi kredensial pada update terpisah
            $encryptedSsh = encrypt($request->ssh_password);
            $encryptedDb = encrypt($request->db_password);

            // 1. Simpan update langsung ke table sub_domains
            $subdomain->update([
                'ip_server'    => $request->ip_server,
                'ssh_user'     => $request->ssh_user,
                'ssh_password' => $encryptedSsh,
                'db_name'      => $request->db_name,
                'db_user'      => $request->db_user,
                'db_password'  => $encryptedDb,
                'app_path'     => $request->app_path,
            ]);

            // 2. Jika Anda menggunakan table relasi hosting_access, lakukan sinkronisasi juga di sini
            if (method_exists($subdomain, 'hostingAccess')) {
                $subdomain->hostingAccess()->updateOrCreate(
                    ['sub_domain_id' => $subdomain->id],
                    [
                        'ip_server'    => $request->ip_server,
                        'ssh_user'     => $request->ssh_user,
                        'ssh_password' => $encryptedSsh,
                        'db_name'      => $request->db_name,
                        'db_user'      => $request->db_user,
                        'db_password'  => $encryptedDb,
                        'app_path'     => $request->app_path,
                    ]
                );
            }

            return redirect()->back()->with('success', 'Parameter konfigurasi hosting berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error("Error Update Hosting Subdomain: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui konfigurasi server: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // ?? KODE INTEGRASI MODAL: PEMBARUAN DAN SINKRONISASI STATUS EDIT MODAL
    // =========================================================================
    /**
     * Memproses perubahan data pengajuan langsung dari Form Modal Edit Admin
     * Menangani pergantian status (Active, Disabled, Rejected) secara dinamis.
     */
    public function updateStatus(Request $request, $id)
    {
        $subdomain = SubDomain::findOrFail($id);

        // Validasi input teks dasar dari modal edit
        $validator = Validator::make($request->all(), [
            'nama_organisasi' => 'required|string|max:255',
            'status'          => 'required|in:Active,approved,Disabled,disabled,Reject,rejected,pending',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal memproses data: ' . $validator->errors()->first());
        }

        try {
            // Pemetaan nama status dari Form Option HTML ke format Enum DB Anda
            $statusInput = strtolower($request->status);
            $finalStatus = 'pending';

            if ($statusInput === 'active' || $statusInput === 'approved') {
                $finalStatus = 'approved';
            } elseif ($statusInput === 'disabled') {
                $finalStatus = 'disabled';
            } elseif ($statusInput === 'reject' || $statusInput === 'rejected') {
                $finalStatus = 'rejected';
            }

            // Update informasi teks dasar subdomain
            $subdomain->update([
                'nama_organisasi' => $request->nama_organisasi,
                'status'          => $finalStatus,
                'updated_at'      => now()
            ]);

            // ?? PERBAIKAN SINKRONISASI EDIT MODAL: Ambil, Enkripsi, dan Simpan Parameter Server dari Form Modal jika tersedia
            if ($request->has('ip_server') && $request->filled('ip_server')) {
                
                $encryptedSsh = $request->filled('ssh_password') ? encrypt($request->ssh_password) : $subdomain->ssh_password;
                $encryptedDb = $request->filled('db_password') ? encrypt($request->db_password) : $subdomain->db_password;

                $subdomain->update([
                    'ip_server'    => $request->ip_server,
                    'ssh_user'     => $request->ssh_user,
                    'ssh_password' => $encryptedSsh,
                    'db_name'      => $request->db_name,
                    'db_user'      => $request->db_user,
                    'db_password'  => $encryptedDb,
                    'app_path'     => $request->app_path,
                ]);

                if (method_exists($subdomain, 'hostingAccess')) {
                    $subdomain->hostingAccess()->updateOrCreate(
                        ['sub_domain_id' => $subdomain->id],
                        [
                            'ip_server'    => $request->ip_server,
                            'ssh_user'     => $request->ssh_user,
                            'ssh_password' => $encryptedSsh,
                            'db_name'      => $request->db_name,
                            'db_user'      => $request->db_user,
                            'db_password'  => $encryptedDb,
                            'app_path'     => $request->app_path,
                        ]
                    );
                }
            }

            // Memicu pengiriman notifikasi/email sesuai perubahan status terbaru
            if ($finalStatus === 'approved') {
                Notification::create([
                    'user_id' => $subdomain->user_id,
                    'title'   => 'Permohonan Subdomain Aktif',
                    'message' => 'Subdomain ' . $subdomain->nama_sub_domain . ' Anda saat ini telah berstatus AKTIF.',
                    'is_read' => 0,
                ]);

                Mail::send('emails.subdomain_status', [
                    'nama_pemohon' => $subdomain->nama_admin,
                    'subdomain'    => $subdomain->nama_sub_domain,
                    'status'       => 'APPROVED / ACTIVE',
                    'keterangan'   => 'Subdomain Anda telah dikonfigurasi dan sukses diaktifkan oleh Admin.',
                    'ip_server'    => $request->ip_server,
                    'ssh_user'     => $request->ssh_user,
                    'ssh_password' => $request->ssh_password,
                    'db_name'      => $request->db_name,
                    'db_user'      => $request->db_user,
                    'db_password'  => $request->db_password,
                    'app_path'     => $request->app_path,
                ], function($message) use ($subdomain) {
                    $message->to($subdomain->email_admin)->subject('Status Subdomain Aktif: ' . $subdomain->nama_sub_domain);
                });

            } elseif ($finalStatus === 'rejected') {
                Notification::create([
                    'user_id' => $subdomain->user_id,
                    'title'   => 'Permohonan Subdomain Ditolak',
                    'message' => 'Pengajuan subdomain ' . $subdomain->nama_sub_domain . ' ditolak melalui pembaharuan admin.',
                    'is_read' => 0,
                ]);
            }

            return redirect()->back()->with('success', 'Data pengajuan dan status subdomain berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error("Error Update Status Subdomain via Modal: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui status pengajuan: ' . $e->getMessage());
        }
    }
}