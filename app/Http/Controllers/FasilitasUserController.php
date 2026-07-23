<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class FasilitasUserController extends Controller
{
    public function index()
    {
        // Fitur Tambahan: Pengecekan Link Storage Otomatis (Anti-Blank)
        // Jika folder storage di public tidak ditemukan, sistem akan membuatnya secara mandiri
        $this->ensureStorageLinkExists();

        // Ambil semua fasilitas beserta relasi gambarnya
        $fasilitas = Fasilitas::with('gambar')->get();

        return view('user.fasilitas', compact('fasilitas'));
    }

    /**
     * Kode Baru: Memastikan jalur gambar (symlink) tersedia di hosting.
     * Ini mengatasi masalah gambar yang muncul sebagai kotak putih (blank).
     */
    protected function ensureStorageLinkExists()
    {
        $publicStoragePath = public_path('storage');

        if (!File::exists($publicStoragePath)) {
            try {
                // Mencoba membuat link secara sistem
                Artisan::call('storage:link');
            } catch (\Exception $e) {
                // Fallback: Membuat manual symlink jika Artisan dilarang oleh hosting
                if (function_exists('symlink')) {
                    @symlink(storage_path('app/public'), $publicStoragePath);
                }
            }
        }
    }
}