<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Data admin yang login
        return view('admin.profile', compact('user'));
    }
    public function edit()
{
    $user = Auth::user();
    return view('admin.profile_edit', compact('user'));
}

public function update(Request $request)
{
    $user = Auth::user();
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    $user->update($request->only('username','email'));
    return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui');
}

}
