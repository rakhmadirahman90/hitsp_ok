<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomRequest extends Model
{
    use HasFactory;

    protected $table = 'zoom_requests';

    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'unit',
        'jenis_kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'email',
        'keterangan',
        'status',
        'link_zoom',
    ];

    // relasi ke user login
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
