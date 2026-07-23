<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPlan;
use Illuminate\Support\Facades\Storage;

class MasterPlanController extends Controller
{
    /**
     * Tampilkan halaman kelola master plan
     */
    public function index()
    {
        $masterplans = MasterPlan::orderBy('created_at', 'desc')->get();

        return view('admin.kelolamasterplane', compact('masterplans'));
    }

    /**
     * Simpan data master plan ke database
     */
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'judul' => 'required|string|max:255',
            'file'  => 'required|mimes:pdf|max:5120', // max 5MB
        ]);

        // SIMPAN FILE
        $file      = $request->file('file');
        $fileName  = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('masterplan', $fileName, 'public');

        // SIMPAN KE DATABASE
        MasterPlan::create([
            'judul' => $request->judul,
            'file'  => $fileName,
        ]);

        return redirect()
            ->route('admin.kelolamasterplane')
            ->with('success', 'Dokumen berhasil ditambahkan');
    }

    /**
     * Hapus master plan
     */
    public function destroy($id)
    {
        $masterplan = MasterPlan::findOrFail($id);

        // HAPUS FILE
        if (Storage::disk('public')->exists('masterplan/' . $masterplan->file)) {
            Storage::disk('public')->delete('masterplan/' . $masterplan->file);
        }

        // HAPUS DATA
        $masterplan->delete();

        return redirect()
            ->route('admin.kelolamasterplane')
            ->with('success', 'Dokumen berhasil dihapus');
    }
}
