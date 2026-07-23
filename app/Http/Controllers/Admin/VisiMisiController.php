<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisiMisi;

class VisiMisiController extends Controller
{
    // ===============================
    // TAMPILKAN HALAMAN
    // ===============================
    public function index()
    {
        $this->authorizeAccess();

        $data = VisiMisi::first();

        // pecah misi kalau ada
        $misiList = [];

        if ($data && $data->misi) {
            $misiList = is_array($data->misi)
                ? $data->misi
                : json_decode($data->misi, true);
        }

        return view('admin.visimisi', [
            'visi' => $data,
            'misiList' => $misiList
        ]);
    }

    // ===============================
    // SIMPAN DATA
    // ===============================
    public function store(Request $request)
    {
        $this->authorizeAccess();

        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|array',
            'misi.*' => 'required|string',
        ]);

        VisiMisi::updateOrCreate(
            ['id' => 1],
            [
                'visi' => $request->visi,

                // SIMPAN JSON BIAR AMAN
                'misi' => json_encode(array_values($request->misi)),
            ]
        );

        return redirect()
            ->route('admin.visimisi.index')
            ->with('success', 'Visi & Misi berhasil disimpan');
    }

    // ===============================
    // CEK ROLE
    // ===============================
    private function authorizeAccess()
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, ['admin', 'operator'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }
}