<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasGambar extends Model
{
    protected $table = 'fasilitas_gambar';

    protected $fillable = [
        'fasilitas_id',
        'gambar',    // Menjaga kompatibilitas jika kolom ini ada
        'nama_file'  // ⬅️ SESUAI DENGAN DATABASE ANDA
    ];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
}