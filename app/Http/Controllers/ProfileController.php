<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|max:18',
            'email' => 'required|email',
 	    'institution' => 'nullable|string|max:255',

            'new_password' =>
                'nullable|min:8|confirmed',
        ],[
            'new_password.confirmed' =>
                'Konfirmasi password tidak cocok.',

            'new_password.min' =>
                'Password minimal 8 karakter.',
        ]);


        // jika ganti password
        if($request->filled('new_password')){

            // cek password lama
            if(!Hash::check(
                $request->current_password,
                $user->password
            )){
                return back()
                    ->withErrors([
                      'current_password' =>
                      'Password lama salah.'
                    ])
                    ->withInput();
            }

            $user->password=
                Hash::make($request->new_password);
        }
$user->name = $request->name;
$user->username = $request->username;
$user->email = $request->email;
$user->institution = $request->institution;

$user->save();
        return back()->with(
            'success',
            'Profil berhasil diperbarui'
        );
    }
}