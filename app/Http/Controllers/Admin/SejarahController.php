<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sejarah;
use App\Models\SejarahGambar;

class SejarahController extends Controller
{
    public function index()
    {
        $sejarah = Sejarah::first();
        $gambar = SejarahGambar::all();

        return view('admin.sejarah', compact('sejarah', 'gambar'));
    }

    public function store(Request $request)
    {
        Sejarah::updateOrCreate(
            ['id' => 1],
            ['isi_sejarah' => $request->isi_sejarah]
        );

        return back()->with('success', 'Sejarah berhasil disimpan');
    }

    public function uploadGambar(Request $request)
    {
        $file = $request->file('gambar');
        $nama = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/sejarah'), $nama);

        SejarahGambar::create([
            'gambar' => $nama
        ]);

        return back();
    }

    public function deleteGambar($id)
    {
        $gambar = SejarahGambar::findOrFail($id);
        unlink(public_path('uploads/sejarah/'.$gambar->gambar));
        $gambar->delete();

        return back();
    }
}

