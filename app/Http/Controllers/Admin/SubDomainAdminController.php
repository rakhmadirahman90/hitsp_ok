<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubDomain;
use App\Models\HostingAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\HostingApprovedMail;
use App\Mail\SubdomainRejectedMail;
use App\Mail\SubdomainUpdatedMail; // <-- Ditambahkan untuk menangani email pembaharuan data

class SubDomainAdminController extends Controller
{
    /**
     * LIST PERMOHONAN
     */
    public function index()
    {
        $subdomains = SubDomain::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.kelolahosting', compact('subdomains'));
    }

    /**
     * DETAIL PERMOHONAN
     */
    public function show($id)
    {
        // Menyertakan relasi hostingAccess agar datanya bisa dibaca langsung di Blade Detail
        $subdomain = SubDomain::with('hostingAccess')->findOrFail($id);

        // PERBAIKAN: Dekripsi password sebelum dikirim ke view agar form input tidak kosong/menampilkan string hash
        if ($subdomain->hostingAccess) {
            try {
                $subdomain->hostingAccess->ssh_password = decrypt($subdomain->hostingAccess->ssh_password);
            } catch (\Exception $e) {
                // Jika password lama berupa teks biasa atau bcrypt lama, biarkan kosong/asli agar tidak crash
            }

            try {
                $subdomain->hostingAccess->db_password = decrypt($subdomain->hostingAccess->db_password);
            } catch (\Exception $e) {
                // Jika password lama berupa teks biasa atau bcrypt lama, biarkan kosong/asli agar tidak crash
            }
        }

        return view('admin.detailhosting', compact('subdomain'));
    }

    /**
     * APPROVE HOSTING
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'ip_server'    => 'required',
            'ssh_user'     => 'required',
            'ssh_password' => 'required',
            'db_name'      => 'required',
            'db_user'      => 'required',
            'db_password'  => 'required',
            'app_path'     => 'required',
        ]);

        DB::transaction(function () use ($request, $id) {

            $hosting = HostingAccess::where(
                'sub_domain_id',
                $id
            )->first();

            // PERBAIKAN: Menggunakan encrypt() sebagai pengganti bcrypt() agar data password dapat didekripsi di halaman detail
            if (!$hosting) {

                HostingAccess::create([
                    'sub_domain_id' => $id,
                    'ip_server'     => $request->ip_server,
                    'ssh_user'      => $request->ssh_user,
                    'ssh_password'  => encrypt($request->ssh_password),
                    'db_name'       => $request->db_name,
                    'db_user'       => $request->db_user,
                    'db_password'   => encrypt($request->db_password),
                    'app_path'      => $request->app_path,
                ]);

            } else {

                $hosting->update([
                    'ip_server'     => $request->ip_server,
                    'ssh_user'      => $request->ssh_user,
                    'ssh_password'  => encrypt($request->ssh_password),
                    'db_name'       => $request->db_name,
                    'db_user'       => $request->db_user,
                    'db_password'   => encrypt($request->db_password),
                    'app_path'      => $request->app_path,
                ]);
            }

            SubDomain::where('id', $id)->update([
                'status' => 'active'
            ]);
        }); // <-- SUDAH DIPERBAIKI: Menggunakan }); bukan ];

        $subdomain = SubDomain::with('hostingAccess')
                        ->findOrFail($id);

        // Mengirim email informasi akun hosting ke penanggung jawab teknis
        Mail::to($subdomain->email_teknis)
            ->send(new HostingApprovedMail($subdomain));

        // Dialihkan kembali menggunakan back() atau penyesuaian untuk menghindari RouteNotFoundException jika rute spesifik tidak terdaftar
        return redirect()
            ->back()
            ->with(
                'success',
                'Hosting berhasil diaktifkan. Informasi akun komplit telah dikirimkan ke email teknis pemohon.'
            );
    }

    /**
     * REJECT
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_tolak' => 'required|string'
        ]);

        $subdomain = SubDomain::findOrFail($id);

        DB::transaction(function () use ($subdomain, $request) {

            HostingAccess::where(
                'sub_domain_id',
                $subdomain->id
            )->delete();

            // Menyimpan alasan penolakan secara permanen di database
            $subdomain->update([
                'status'       => 'rejected',
                'alasan_tolak' => $request->alasan_tolak
            ]);
        });

        // Mengirim notifikasi penolakan bersama alasannya ke email teknis pemohon
        Mail::to($subdomain->email_teknis)
            ->send(
                new SubdomainRejectedMail(
                    $subdomain,
                    $request->alasan_tolak
                )
            );

        // Dialihkan kembali ke halaman kelola utama menggunakan back() agar aman dari issue Route Not Found
        return redirect()
            ->back()
            ->with(
                'error',
                'Permohonan berhasil ditolak. Pemberitahuan alasan penolakan telah dikirimkan ke email teknis pemohon.'
            );
    }

    /**
     * DISABLE HOSTING
     */
    public function disable($id)
    {
        $subdomain = SubDomain::findOrFail($id);

        DB::transaction(function () use ($subdomain) {
            // PERBAIKAN: Jangan hapus (delete) data HostingAccess saat disabled agar form parameter bawah tetap muncul di view
            $subdomain->update([
                'status' => 'disabled'
            ]);
        });

        return redirect()
            ->route('admin.subdomain.index')
            ->with(
                'info',
                'Hosting berhasil dinonaktifkan'
            );
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        try {

            DB::transaction(function () use ($id) {

                $subdomain = SubDomain::findOrFail($id);

                HostingAccess::where(
                    'sub_domain_id',
                    $id
                )->delete();

                $subdomain->delete();
            });

            return back()->with(
                'success',
                'Data berhasil dihapus.'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Gagal menghapus data: ' . $e->getMessage()
            );
        }
    }

    // =======================================================================
    // PERBAIKAN FITUR: UPDATE DATA PENGAJUAN (LOCK DATA ATAS, EDIT PARAMETER BAWAH)
    // =======================================================================
    /**
     * UPDATE DATA PENGAJUAN (KUNCI INPUT UTAMA, HANYA EDIT STATUS & PARAMETER SERVER)
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input Terfokus (Data atas ditiadakan dari required karena bersifat Readonly)
        $request->validate([
            'status'          => 'required|in:pending,active,disabled,rejected',
            
            // Validasi parameter konfigurasi hosting yang bebas diubah kapan saja
            'ip_server'       => 'nullable|string|max:255',
            'ssh_user'        => 'nullable|string|max:255',
            'ssh_password'    => 'nullable|string',
            'db_name'         => 'nullable|string|max:255',
            'db_user'         => 'nullable|string|max:255',
            'db_password'     => 'nullable|string',
            'app_path'        => 'nullable|string|max:255',
        ]);

        try {
            $subdomain = null;

            DB::transaction(function () use ($request, $id, &$subdomain) {
                // 2. Cari data pengajuan subdomain berdasarkan ID
                $subdomain = SubDomain::findOrFail($id);

                // PERBAIKAN LOGIKA: Sesuai instruksi, form atas dikunci total. Admin hanya memperbarui Status Pengajuan saja!
                $subdomain->update([
                    'status' => $request->status,
                ]);

                // 3. Update atau Create data parameter konfigurasi hosting_access dari form bagian bawah
                $hostingData = [
                    'ip_server' => $request->ip_server,
                    'ssh_user'  => $request->ssh_user,
                    'db_name'   => $request->db_name,
                    'db_user'   => $request->db_user,
                    'app_path'  => $request->app_path,
                ];

                // Hanya enkripsi ulang password jika admin menuliskan isi password baru pada form edit
                if ($request->filled('ssh_password')) {
                    $hostingData['ssh_password'] = encrypt($request->ssh_password);
                }
                if ($request->filled('db_password')) {
                    $hostingData['db_password'] = encrypt($request->db_password);
                }

                HostingAccess::updateOrCreate(
                    ['sub_domain_id' => $id],
                    $hostingData
                );

                // Jika status diubah paksa menjadi 'rejected', hapus akses servernya secara otomatis
                if ($request->status === 'rejected') {
                    HostingAccess::where('sub_domain_id', $id)->delete();
                }
            });

            // 4. Kirim Notifikasi Perubahan Lengkap ke Email Pemohon Terdaftar
            if ($subdomain) {
                try {
                    Mail::to($subdomain->email_teknis)->send(new SubdomainUpdatedMail($subdomain));
                } catch (\Exception $mailException) {
                    // Jika SMTP Error, data di DB tetap tersimpan aman namun memunculkan alert info
                    return redirect()
                        ->back()
                        ->with('info', 'Parameter hosting berhasil diperbarui, namun sistem gagal mengirimkan email notifikasi: ' . $mailException->getMessage());
                }
            }

            // PERBAIKAN SEBELUMNYA: Menggunakan back() untuk mencegah crash RouteNotFoundException
            return redirect()
                ->back()
                ->with('success', 'Parameter konfigurasi hosting dan status pengajuan berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui data parameter hosting: ' . $e->getMessage());
        }
    }

    // =======================================================================
    // KODE BARU: METHOD KHUSUS UNTUK MEMPERBARUI PARAMETER HOSTING SAJA (FORM BAWAH)
    // =======================================================================
    /**
     * UPDATE HANYA PARAMETER KONFIGURASI HOSTING (AKSES SERVER KAPAN SAJA)
     */
    public function updateHosting(Request $request, $id)
    {
        $request->validate([
            'ip_server'   => 'required|string|max:255',
            'ssh_user'    => 'required|string|max:255',
            'db_name'     => 'required|string|max:255',
            'db_user'     => 'required|string|max:255',
            'app_path'    => 'required|string|max:255',
            'ssh_password'=> 'nullable|string',
            'db_password' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                // Pastikan data induk subdomain ada
                $subdomain = SubDomain::findOrFail($id);

                $hostingData = [
                    'ip_server' => $request->ip_server,
                    'ssh_user'  => $request->ssh_user,
                    'db_name'   => $request->db_name,
                    'db_user'   => $request->db_user,
                    'app_path'  => $request->app_path,
                ];

                // PERBAIKAN: Hanya update password jika diisi baru pada form parameter server, jika kosong biarkan data lama bertahan
                if ($request->filled('ssh_password')) {
                    $hostingData['ssh_password'] = encrypt($request->ssh_password);
                }
                if ($request->filled('db_password')) {
                    $hostingData['db_password'] = encrypt($request->db_password);
                }

                // Simpan atau perbarui parameter server hosting terkait
                HostingAccess::updateOrCreate(
                    ['sub_domain_id' => $id],
                    $hostingData
                );
            });

            return redirect()
                ->back()
                ->with('success', 'Parameter konfigurasi hosting (Akses Server) berhasil diperbarui secara dinamis!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui parameter hosting: ' . $e->getMessage());
        }
    }
}