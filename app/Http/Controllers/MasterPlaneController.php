<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterPlan; // pastikan model ada
use Illuminate\Http\Request;

class MasterPlaneController extends Controller
{
    public function index()
    {
        $masterplans = MasterPlan::latest()->get(); // ambil semua dokumen
        return view('user.masterplane', compact('masterplans'));
    }
}
