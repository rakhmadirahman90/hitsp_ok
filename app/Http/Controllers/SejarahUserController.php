<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sejarah;
use App\Models\SejarahGambar;

class SejarahUserController extends Controller
{
    public function index()
    {
        return view('user.sejarah', [
            'sejarah' => Sejarah::first(),
            'gambar'  => SejarahGambar::all()
        ]);
    }
}
