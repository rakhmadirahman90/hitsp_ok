<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunEmailPribadi extends Model
{
    use HasFactory;

    protected $table = 'akun_email_pribadi';

    protected $fillable = [
        'permohonan_id',
        'nama_akun',
        'password',
    ];

    public function permohonan()
    {
        return $this->belongsTo(\App\Models\PermohonanEmailPribadi::class, 'permohonan_id');
    }
}
