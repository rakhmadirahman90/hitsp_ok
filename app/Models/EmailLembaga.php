<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLembaga extends Model
{
    use HasFactory;

    protected $table = 'emails_lembaga';

    protected $fillable = [
        'jenis_akun',
        'nama_akun',
        'password_hash',
        'email_pemohon',
        'status',
    ];
}
