<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pengumuman;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // ===============================
    // HALAMAN DASHBOARD
    // ===============================
    public function index()
{
    $this->authorizeAccess(); // tetap cek role

    $user = auth()->user();

    // Data yang sama untuk semua role
    $data = [
        'layanans'    => Layanan::all(),
        'pengumumans' => Pengumuman::latest()->get(),
        'kegiatans'   => Kegiatan::latest()->get(),
    ];

    // Pilih layout berdasarkan role
    $layout = $user->role === 'admin' ? 'admin.layout' : 'operator.layout';

    // Kirim data + layout ke satu blade: resources/views/dashboard.blade.php
    return view('admin.keloladashboard', array_merge($data, ['layout' => $layout]));
}

    /* ================= LAYANAN ================= */
    public function storeLayanan(Request $request)
    {
        $this->authorizeAccess();

        $data = $request->validate([
            'nama' => 'required',
            'icon' => 'required'
        ]);

        Layanan::create($data);
        return response()->json(['success' => true]);
    }

    public function updateLayanan(Request $request, $id)
    {
        $this->authorizeAccess();

        $layanan = Layanan::findOrFail($id);

        $layanan->update($request->validate([
            'nama' => 'required',
            'icon' => 'required'
        ]));

        return response()->json(['success' => true]);
    }

    public function deleteLayanan($id)
    {
        $this->authorizeAccess();

        Layanan::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    /* ================= PENGUMUMAN ================= */
    public function storePengumuman(Request $request)
    {
        $this->authorizeAccess();

        $data = $request->validate([
            'tanggal' => 'required|date',
            'isi' => 'required'
        ]);

        Pengumuman::create($data);
        return response()->json(['success' => true]);
    }

    public function updatePengumuman(Request $request, $id)
    {
        $this->authorizeAccess();

        $p = Pengumuman::findOrFail($id);

        $p->update($request->validate([
            'tanggal' => 'required|date',
            'isi' => 'required'
        ]));

        return response()->json(['success' => true]);
    }

    public function deletePengumuman($id)
    {
        $this->authorizeAccess();

        Pengumuman::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    /* ================= KEGIATAN ================= */
    public function storeKegiatan(Request $request)
    {
        $this->authorizeAccess();

        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|max:2048'
        ]);

        $data['gambar'] = $request->file('gambar')->store('kegiatan', 'public');

        Kegiatan::create($data);
        return response()->json(['success' => true]);
    }

    public function updateKegiatan(Request $request, $id)
    {
        $this->authorizeAccess();

        $k = Kegiatan::findOrFail($id);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($k->gambar);
            $k->gambar = $request->file('gambar')->store('kegiatan', 'public');
        }

        $k->judul = $request->judul;
        $k->deskripsi = $request->deskripsi;
        $k->save();

        return response()->json(['success' => true]);
    }

    public function deleteKegiatan($id)
    {
        $this->authorizeAccess();

        $k = Kegiatan::findOrFail($id);
        Storage::disk('public')->delete($k->gambar);
        $k->delete();

        return response()->json(['success' => true]);
    }

    // ===============================
    // FUNGSI CEK ROLE ADMIN/OPERATOR
    // ===============================
    private function authorizeAccess()
    {
        $user = auth()->user();

        if (!$user || ($user->role != 'admin' && $user->role != 'operator')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }
}
