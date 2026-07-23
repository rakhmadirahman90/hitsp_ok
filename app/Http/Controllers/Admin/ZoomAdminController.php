<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZoomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ZoomApprovedMail;
use App\Mail\ZoomUpdatedMail; // <-- Ditambahkan untuk menangani email pembaharuan data Zoom

class ZoomAdminController extends Controller
{

    /**
     * Daftar request zoom
     * 10 data per halaman
     */
    public function index()
    {
        $requests = ZoomRequest::latest()
                    ->paginate(10);

        return view(
            'admin.kelolazoom',
            compact('requests')
        );
    }



    /**
     * Detail request zoom
     */
    public function show($id)
    {
        $request = ZoomRequest::findOrFail($id);

        return view(
            'admin.showzoom',
            compact('request')
        );
    }



    /**
     * Approve + kirim email zoom
     */
    public function approve(Request $request,$id)
    {
        $request->validate([
            'link_zoom'=>'required|url'
        ]);


        $zoom = ZoomRequest::findOrFail($id);


        $zoom->update([
            'link_zoom'=>$request->link_zoom,
            'status'=>'approved'
        ]);


        // kirim email otomatis
        Mail::to(
            $zoom->email
        )->send(
            new ZoomApprovedMail($zoom)
        );


        return redirect()
            ->route('admin.zoom.index')
            ->with(
                'success',
                'Link Zoom berhasil diberikan dan email telah dikirim ke user.'
            );
    }




    /**
     * Hapus request
     */
    public function delete($id)
    {
        $data = ZoomRequest::findOrFail($id);

        $data->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }

    // =======================================================================
    // KODE BARU: PEMBAHARUAN ADMIN PENGAJUAN ZOOM (METHOD UPDATE)
    // =======================================================================
    /**
     * UPDATE DATA PENGAJUAN ZOOM & STATUS + EMAIL NOTIFIKASI
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input Data Form Edit sesuai dengan struktur modal blade dan ENUM database terbaru
        $request->validate([
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'status'         => 'required|in:pending,approved,rejected,disabled', // <-- Diperbarui agar sinkron dengan ENUM MySQL Anda
        ]);

        try {
            // 2. Cari data pengajuan Zoom berdasarkan ID
            $zoom = ZoomRequest::findOrFail($id);

            // 3. Update field data utama pengajuan Zoom
            $zoom->update([
                'nama'           => $request->nama,
                'email'          => $request->email,
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'tanggal'        => $request->tanggal,
                'status'         => $request->status,
            ]);

            // 4. Kirim Notifikasi Perubahan ke Email Pemohon Terdaftar
            try {
                Mail::to($zoom->email)->send(new ZoomUpdatedMail($zoom));
            } catch (\Exception $mailException) {
                // Jika server SMTP Mail sedang bermasalah, data di DB tetap tersimpan aman namun memunculkan alert info
                return redirect()
                    ->back()
                    ->with('info', 'Data pengajuan Zoom berhasil diperbarui, namun sistem gagal mengirimkan email notifikasi: ' . $mailException->getMessage());
            }

            // 5. Kembalikan ke halaman sebelumnya dengan alert sukses
            return redirect()
                ->back()
                ->with('success', 'Data pengajuan Zoom berhasil diperbarui dan email perubahan telah dikirim!');

        } catch (\Exception $e) {
            // Tangkap kesalahan tidak terduga lainnya
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // =======================================================================
    // KODE BARU: LOGIKA UNTUK MENANGANI AKSI TOMBOL NONAKTIFKAN (DISABLE)
    // =======================================================================
    /**
     * Nonaktifkan pengajuan Zoom (Sama dengan alur Pengajuan Hosting)
     */
    public function disable($id)
    {
        try {
            $zoom = ZoomRequest::findOrFail($id);
            
            // Ubah status pengajuan menjadi disabled
            $zoom->update([
                'status' => 'disabled'
            ]);

            return redirect()
                ->back()
                ->with('success', 'Layanan pengajuan Zoom berhasil dinonaktifkan.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menonaktifkan layanan: ' . $e->getMessage());
        }
    }

}