<?php

namespace App\Http\Controllers;
use App\Models\Notification; // ?? TAMBAHAN INI SAJA
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ================= REGISTRASI =================
    public function registerForm()
    {
        return view('user.registrasi');
    }

 public function registerStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|digits_between:5,18|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
                'confirmed'
            ],
            'role'     => 'required|in:mahasiswa,dosen,staf',
        ], [
            'name.required'            => 'Nama wajib diisi',
            'username.digits_between'  => 'NIM/NIP harus 5-18 digit',
            'username.unique'          => 'NIM/NIP sudah terdaftar',
            'email.unique'             => 'Email sudah terdaftar',
            'password.min'             => 'Password minimal 8 karakter',
            'password.regex'           => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol',
            'password.confirmed'       => 'Konfirmasi password tidak cocok',
        ]);

        // ================= CREATE USER =================
        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => 'pending'
        ]);

        // ================= ?? TAMBAHAN NOTIFIKASI (REGISTER SAJA) =================
        Notification::create([
            'user_id' => null, // untuk admin
            'title' => 'Pendaftaran User Baru',
            'message' => $user->name . ' baru saja mendaftar',
            'is_read' => 0,
        ]);

        return redirect()->route('login')
        ->with(
            'success',
            'Registrasi berhasil, menunggu persetujuan admin'
        );
    }

    // ================= LOGIN =================
    public function loginForm()
    {
        return view('user.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // ================= CEK STATUS =================
            if($user->status == 'pending'){

                Auth::logout();

                return back()->withErrors([
                    'username' =>
                    'Akun anda masih menunggu persetujuan admin'
                ]);

            }

            if($user->status == 'rejected'){

                Auth::logout();

                return back()->withErrors([
                    'username' =>
                    'Akun anda ditolak admin'
                ]);

            }

            // ================= REDIRECT ROLE =================
            if ($user->role === 'admin') {

                return redirect()->route('admin.kelolapengguna');

            } elseif ($user->role === 'operator') {

                return redirect()->route('admin.keloladashboard');

            } else {

                return redirect()->route('dashboard');

            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // ================= PROFIL USER =================
    public function showProfile()
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    // ================= UPDATE PROFIL =================
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|digits_between:5,20|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
	    'institution' => 'nullable|string|max:255',
	    'institution_domain' => 'nullable|string|max:50',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ], [
            'username.digits_between' => 'NIM/NIP harus 5-20 digit',
            'username.unique' => 'NIM/NIP sudah terdaftar',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
            'name.required' => 'Nama wajib diisi',
        ]);

        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
	$user->institution = $request->institution;
	$user->institution_domain = strtolower($request->institution_domain);

        // Jika user ingin ganti password
        if ($request->new_password) {

            if (!Hash::check($request->current_password, $user->password)) {

                return back()->withErrors([
                    'current_password' => 'Password lama salah'
                ]);

            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with(
            'success',
            'Profil berhasil diperbarui!'
        );
    }
}