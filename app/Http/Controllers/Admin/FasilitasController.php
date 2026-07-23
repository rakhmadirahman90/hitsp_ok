<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\FasilitasGambar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FasilitasController extends Controller
{
    public function index()
    {
        // Menggunakan withCount untuk efisiensi pengambilan jumlah gambar
        $fasilitas = Fasilitas::withCount('gambar')->get();
        return view('admin.kelolafasilitas', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        // PERBAIKAN 1: Deteksi nama input yang fleksibel
        $inputNama = $request->has('nama_fasilitas') ? 'nama_fasilitas' : 'nama';

        // PERBAIKAN 2: Validasi lebih longgar pada mimes untuk menghindari penolakan server
        $request->validate([
            $inputNama => 'required|string|max:255',
            'foto.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5000', 
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5000'
        ]);

        try {
            // Simpan data fasilitas
            $fasilitas = Fasilitas::create([
                'nama' => $request->$inputNama
            ]);

            // LOGIKA UPLOAD: Mendukung input name="foto[]" atau name="gambar[]"
            $files = $request->file('foto') ?? $request->file('gambar');

            if ($files) {
                // PERBAIKAN 3: Gunakan Storage::disk('public') agar sinkron dengan WinSCP
                if (!Storage::disk('public')->exists('fasilitas')) {
                    Storage::disk('public')->makeDirectory('fasilitas');
                }

                foreach ($files as $file) {
                    $namaFile = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    
                    // Simpan file menggunakan Disk Public
                    // Ini akan masuk ke storage/app/public/fasilitas
                    $file->storeAs('fasilitas', $namaFile, 'public');

                    FasilitasGambar::create([
                        'fasilitas_id' => $fasilitas->id,
                        'gambar' => $namaFile
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Fasilitas berhasil ditambahkan');

        } catch (\Exception $e) {
            // Jika gagal, catat di log dan tampilkan pesan error
            Log::error("Gagal tambah fasilitas: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $inputNama = $request->has('nama_fasilitas') ? 'nama_fasilitas' : 'nama';

        $request->validate([
            $inputNama => 'required|string|max:255',
            'foto.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5000',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5000'
        ]);

        try {
            $fasilitas = Fasilitas::findOrFail($id);
            $fasilitas->update(['nama' => $request->$inputNama]);

            // Logika Penghapusan Foto (Tombol X)
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imgId) {
                    $img = FasilitasGambar::find($imgId);
                    if ($img) {
                        if (Storage::disk('public')->exists('fasilitas/' . $img->gambar)) {
                            Storage::disk('public')->delete('fasilitas/' . $img->gambar);
                        }
                        $img->delete();
                    }
                }
            }

            // Simpan gambar baru jika ada yang diunggah
            $files = $request->file('foto') ?? $request->file('gambar');
            if ($files) {
                foreach ($files as $file) {
                    $namaFile = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->storeAs('fasilitas', $namaFile, 'public');

                    FasilitasGambar::create([
                        'fasilitas_id' => $id,
                        'gambar' => $namaFile
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Fasilitas berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $fasilitas = Fasilitas::findOrFail($id);
            
            $gambarTerakait = FasilitasGambar::where('fasilitas_id', $id)->get();
            foreach ($gambarTerakait as $item) {
                if (Storage::disk('public')->exists('fasilitas/' . $item->gambar)) {
                    Storage::disk('public')->delete('fasilitas/' . $item->gambar);
                }
            }

            FasilitasGambar::where('fasilitas_id', $id)->delete();
            $fasilitas->delete();
            
            return redirect()->back()->with('success', 'Fasilitas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }
    }

    /**
     * PERBAIKAN: Fungsi destroyGambar sekarang mendukung permintaan AJAX/Fetch
     */
    public function destroyGambar($id)
    {
        try {
            $gambar = FasilitasGambar::findOrFail($id);
            
            // Hapus file fisik dari folder storage/app/public/fasilitas
            if (Storage::disk('public')->exists('fasilitas/' . $gambar->gambar)) {
                Storage::disk('public')->delete('fasilitas/' . $gambar->gambar);
            }

            // Hapus dari database
            $gambar->delete();

            // CEK: Jika permintaan datang dari AJAX (Fetch)
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto berhasil dihapus secara permanen'
                ]);
            }

            // Jika permintaan biasa (fallback)
            return redirect()->back()->with('success', 'Foto berhasil dihapus');

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal menghapus gambar');
        }
    }
}