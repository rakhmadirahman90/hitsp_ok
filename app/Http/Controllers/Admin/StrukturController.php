<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\Anggota;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Storage;

class StrukturController extends Controller
{
    // Tampilkan halaman struktur
    public function index()
    {
        $divisis = Divisi::with('anggotas')->get();
        $struktur = StrukturOrganisasi::first();
        return view('admin.kelolastruktur', compact('divisis','struktur'));
    }

    // Tambah divisi
    public function storeDivisi(Request $request)
    {
        $request->validate(['nama'=>'required|string|max:255']);
        Divisi::create(['nama'=>$request->nama]);
        return redirect()->back()->with('success','Divisi berhasil ditambahkan');
    }

    // Edit nama divisi
    public function updateDivisi(Request $request, $id)
    {
        $request->validate(['nama'=>'required|string|max:255']);
        $divisi = Divisi::findOrFail($id);
        $divisi->nama = $request->nama;
        $divisi->save();
        return redirect()->back()->with('success','Nama divisi berhasil diperbarui');
    }

    // Hapus divisi beserta anggotanya & file foto
    public function deleteDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);

        foreach($divisi->anggotas as $anggota){
            if($anggota->foto && Storage::disk('public')->exists($anggota->foto)){
                Storage::disk('public')->delete($anggota->foto);
            }
        }

        $divisi->delete();
        return redirect()->back()->with('success','Divisi beserta anggota berhasil dihapus');
    }

    // Tambah anggota
    public function storeAnggota(Request $request)
    {
        $request->validate([
            'nama'=>'required|string|max:255',
            'peran'=>'required|string|max:255',
            'divisi_id'=>'required|exists:divisis,id',
            'foto'=>'nullable|image|max:2048'
        ]);

        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('uploads','public') : null;

        Anggota::create([
            'nama'=>$request->nama,
            'peran'=>$request->peran,
            'divisi_id'=>$request->divisi_id,
            'foto'=>$fotoPath
        ]);

        return redirect()->back()->with('success','Anggota berhasil ditambahkan');
    }

    // Hapus anggota & foto
    public function deleteAnggota($id)
    {
        $anggota = Anggota::findOrFail($id);

        if($anggota->foto && Storage::disk('public')->exists($anggota->foto)){
            Storage::disk('public')->delete($anggota->foto);
        }

        $anggota->delete();
        return redirect()->back()->with('success','Anggota berhasil dihapus');
    }

    // Update gambar struktur organisasi
    public function updateGambar(Request $request)
    {
        $request->validate(['gambar'=>'required|image|max:2048']);
        $path = $request->file('gambar')->store('struktur','public');

        $struktur = StrukturOrganisasi::first();
        if(!$struktur) $struktur = new StrukturOrganisasi();

        // hapus gambar lama jika ada
        if($struktur->gambar && Storage::disk('public')->exists($struktur->gambar)){
            Storage::disk('public')->delete($struktur->gambar);
        }

        $struktur->gambar = $path;
        $struktur->save();

        return redirect()->back()->with('success','Gambar struktur berhasil diupdate');
    }
    // Tampilkan halaman struktur untuk user
public function tampilUser()
{
    // Ambil gambar struktur (bisa null)
    $struktur = StrukturOrganisasi::first();

    // Ambil semua divisi beserta anggotanya
    $divisis = Divisi::with('anggotas')->get();

    // Kirim ke view user
    return view('user.struktur', compact('struktur', 'divisis'));
}

}
