<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanEmailPribadi extends Model
{
    use HasFactory;

    // Pakai nama tabel yang sesuai migration
    protected $table = 'permohonan_email_pribadi';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'jenis_pemohon',
        'fakultas',
        'jurusan',
        'jabatan',
        'nomor_identitas',
        'no_telp',
        'email_alternatif',
        'file_identitas',
        'email_name',
        'email_domain',
        'rek_nama',
        'rek_identitas',
        'rek_fakultas',
        'rek_email',
        'status',
    ];

    // relasi ke user
    public function user() {
        return $this->belongsTo(User::class);
    }
}
