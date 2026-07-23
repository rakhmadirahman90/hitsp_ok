<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class KelolaPenggunaController extends Controller
{
    // =========================
    // TAMPILKAN DATA USER
    // =========================
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.kelolapengguna', compact('users'));
    }

    // =========================
    // STORE (TAMBAH USER)
    // =========================
    public function store(Request $request)
    {
        $request->validate([

            'nama' => [
                'required',
                'regex:/^[A-Za-z\s]+$/'
            ],

            'username' => [
                'required',
                'numeric',
                'digits_between:1,18',
                'unique:users,username'
            ],

            // EMAIL VALID
            'email' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email'
            ],

            'role' => ['required'],

            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^[A-Z]/', // huruf pertama kapital
                'regex:/[\W_]/'   // wajib simbol
            ]

        ], [

            'nama.required' => 'Nama wajib diisi',
            'nama.regex' => 'Nama hanya boleh huruf',

            'username.required' => 'Username wajib diisi',
            'username.numeric' => 'Username hanya angka',
            'username.digits_between' => 'Username maksimal 18 digit',
            'username.unique' => 'Username sudah terdaftar',

            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email tidak valid',
            'email.max' => 'Email terlalu panjang',
            'email.regex' => 'Email tidak valid (contoh: user@gmail.com)',
            'email.unique' => 'Email sudah terdaftar',

            'role.required' => 'Role wajib dipilih',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',
            'password.regex' => 'Password harus kapital awal & ada simbol'
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 'approved', // admin tambah user langsung approved
            'password' => bcrypt($request->password)
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan');
    }

    // =========================
    // UPDATE USER
    // =========================
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([

            'nama' => [
                'required',
                'regex:/^[A-Za-z\s]+$/'
            ],

            'username' => [
                'required',
                'numeric',
                'digits_between:1,18',
                Rule::unique('users', 'username')->ignore($id)
            ],

            'email' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                Rule::unique('users', 'email')->ignore($id)
            ],

            'role' => ['required'],

            'password' => [
                'nullable',
                'min:8',
                'confirmed',
                'regex:/^[A-Z]/',
                'regex:/[\W_]/'
            ]

        ], [

            'nama.required' => 'Nama wajib diisi',
            'nama.regex' => 'Nama hanya boleh huruf',

            'username.required' => 'Username wajib diisi',
            'username.numeric' => 'Username hanya angka',
            'username.digits_between' => 'Username maksimal 18 digit',
            'username.unique' => 'Username sudah digunakan',

            'email.required' => 'Email wajib diisi',
            'email.regex' => 'Format email tidak valid (contoh: user@gmail.com)',
            'email.unique' => 'Email sudah digunakan',

            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',
            'password.regex' => 'Password harus kapital awal & ada simbol',
        ]);

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'Pengguna berhasil diupdate');
    }

    // =========================
    // APPROVE USER
    // =========================
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'approved';
        $user->save();

        return back()->with('success', 'Pengguna berhasil disetujui');
    }

    // =========================
    // DELETE USER
    // =========================
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // cegah hapus akun sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus');
    }
}