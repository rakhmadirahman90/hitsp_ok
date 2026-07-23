<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanEmail extends Model
{
    use HasFactory;

    protected $table = 'permohonan_email_lembaga';

    protected $fillable = [
        'nama_institusi',
        'nama_kegiatan',
        'nama_akun',
        'email_alternatif',
        'nama_teknis',
        'nip_nik_nim_teknis',
        'jabatan_teknis',
        'status_teknis',
        'telp_teknis',
        'status',
    ];
}