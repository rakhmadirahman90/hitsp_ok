<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahan untuk pengelolaan file yang aman

class LaporanAdminController extends Controller
{
    // Tampilkan semua laporan
    public function index()
    {
        // PERBAIKAN: Gunakan eager loading 'user' agar tidak berat saat load data pengaju
        // Pastikan di Model Laporan sudah ada function user()
        $laporans = Laporan::with('user')->latest()->get();
        return view('admin.kelola_laporan', compact('laporans'));
    }

    // Tampilkan halaman detail laporan
    public function show($id)
    {
        // PERBAIKAN: Tambahkan relasi user agar detail pengaju muncul
        $laporan = Laporan::with('user')->findOrFail($id);
        return view('admin.detaillaporan', compact('laporan'));
    }

    // Terima laporan → ubah status menjadi 'Selesai'
    public function terima($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Menambahkan pengecekan status yang lebih fleksibel
        if ($laporan->status == 'Pending' || $laporan->status == 'Menunggu' || $laporan->status == 'Proses') {
            $laporan->status = 'Selesai';
            $laporan->save();
        }

        return redirect()->back()->with('success', 'Laporan berhasil diterima dan status menjadi Selesai.');
    }

    // Hapus laporan
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        // PERBAIKAN: Menggunakan facade Storage agar lebih standar Laravel
        // Menghapus file bukti dari folder storage/app/public/
        if ($laporan->bukti) {
            if (Storage::disk('public')->exists($laporan->bukti)) {
                Storage::disk('public')->delete($laporan->bukti);
            }
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * TAMBAHAN FITUR: Update Status Custom
     * Berguna jika Anda ingin status 'Ditolak' atau 'Sedang Diproses'
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai,Ditolak'
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui menjadi ' . $request->status);
    }
}