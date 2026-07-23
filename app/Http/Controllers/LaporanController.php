<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Notification; // ?? TAMBAHAN
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function create()
    {
        return view('user.pengajuan');
    }

    public function store(Request $request)
    {
        // ================= 1. VALIDASI =================
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'tingkat_urgensi' => 'required|string',
            'lokasi' => 'required|string',
            'deskripsi' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048'
        ]);

        // ================= 2. UPLOAD BUKTI =================
        $buktiFile = null;
        if ($request->hasFile('bukti')) {
            $buktiFile = $request->file('bukti')
                ->store('bukti_laporan', 'public');
        }

        // ================= 3. GENERATE TICKET =================
        $todayCount = Laporan::whereDate('created_at', now()->toDateString())->count() + 1;
        $ticketNo = 'TKT-' . now()->format('Ymd') . '-' . str_pad($todayCount, 3, '0', STR_PAD_LEFT);

        // ================= 4. IDENTITAS USER =================
        $namaPengirim = auth()->user()->name 
            ?? auth()->user()->nama 
            ?? auth()->user()->username 
            ?? 'User ITH';

        // ================= 5. SIMPAN LAPORAN =================
        Laporan::create([
            'ticket_no' => $ticketNo,
            'user_id' => auth()->id(),
            'nama_pengirim' => $namaPengirim,
            'status_pengirim' => auth()->user()->role ?? 'Mahasiswa',
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tingkat_urgensi' => $request->tingkat_urgensi,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'bukti' => $buktiFile,
            'tanggal' => now()->toDateString(),
            'status' => 'Menunggu',
        ]);

        // ================= ?? NOTIFIKASI ADMIN =================
        Notification::create([
            'user_id' => null,
            'title' => 'Laporan Baru Masuk',
            'message' => $namaPengirim . ' mengirim laporan dengan tiket ' . $ticketNo,
            'is_read' => 0,
        ]);

        return redirect()
            ->route('laporan.create')
            ->with('success', 'Laporan berhasil dikirim! Nomor tiket Anda: ' . $ticketNo);
    }

    public function terima($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status = 'Di Terima';
        $laporan->save();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan telah diterima!');
    }

    public function tracking()
    {
        $laporan = Laporan::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.tracking', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = Laporan::where('user_id', Auth::id())->findOrFail($id);

        return view('user.detaillaporan', compact('laporan'));
    }
}