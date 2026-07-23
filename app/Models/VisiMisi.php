<?php
// app/Models/VisiMisi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    protected $table = 'visi_misi';

    protected $fillable = ['visi', 'misi'];

    protected $casts = [
        'misi' => 'array',
    ];

     public function index()
    {
        // ambil data dari database
        $data = VisiMisi::first();

        // kirim ke halaman user
        return view('user.visimisi', compact('data'));
    }
}
