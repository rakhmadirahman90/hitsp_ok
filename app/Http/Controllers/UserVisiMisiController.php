<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;

class UserVisiMisiController extends Controller
{
    public function index()
    {
        $visiMisi = VisiMisi::first();

        return view('user.visi_misi', compact('visiMisi'));
    }
}
