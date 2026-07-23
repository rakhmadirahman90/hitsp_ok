<?php

namespace App\Http\Controllers;

use App\Models\ZoomRequest;
use App\Models\Notification; // ?? TAMBAHAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomController extends Controller
{
    // Halaman Form
    public function create()
    {
        // CEK LOGIN
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // CEK ROLE MAHASISWA
        if (Auth::user()->role == 'mahasiswa') {
            return redirect()->back()->with(
                'error',
                'Fitur Zoom hanya dapat diakses oleh Dosen dan Staf.'
            );
        }

        return view('user.reqzoom');
    }

    // Simpan Request Zoom
    public function store(Request $request)
    {
        // CEK ROLE MAHASISWA
        if (Auth::user()->role == 'mahasiswa') {
            return redirect()->back()->with(
                'error',
                'Fitur Zoom hanya dapat diakses oleh Dosen dan Staf.'
            );
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'unit' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'email' => 'required|email|max:255',
            'keterangan' => 'nullable|string'
        ]);

        // =========================
        // SIMPAN DATA ZOOM REQUEST
        // =========================
        ZoomRequest::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'nip' => $request->nip,
            'unit' => $request->unit,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'email' => $request->email,
            'keterangan' => $request->keterangan,
        ]);

        // =========================
        // ?? TAMBAHAN NOTIFIKASI ADMIN
        // =========================
        Notification::create([
            'user_id' => null, // untuk admin (global)
            'title' => 'Permintaan Zoom Baru',
            'message' => Auth::user()->name . ' mengajukan permintaan Zoom pada tanggal ' . $request->tanggal,
        ]);

        return redirect()->back()->with(
            'success',
            'Permintaan pembuatan link Zoom berhasil dikirim'
        );
    }
}