<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_domain',
        'nama_organisasi',
        'nama_admin',
        'nip_admin',
        'alamat_kantor_admin',
        'alamat_rumah_admin',
        'telp_kantor_admin',
        'telp_rumah_admin',
        'email_admin',
        'nama_teknis',
        'nip_nim_teknis',
        'alamat_kantor_teknis',
        'alamat_rumah_teknis',
        'telp_kantor_teknis',
        'email_teknis',
        'nama_sub_domain',
        'status',
        // Tambahkan kolom ini agar alasan penolakan bisa disimpan ke database
        'alasan_tolak', 
        
        // =========================================================================
        // KODE BARU: Daftarkan parameter hosting ke fillable agar bisa disimpan
        // =========================================================================
        'ip_server',
        'user_ssh',
        'database_name',
        'database_user',
        'lokasi_aplikasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke hosting access (Tetap terjaga sesuai kode Anda)
    public function hostingAccess()
    {
        return $this->hasOne(HostingAccess::class, 'sub_domain_id');
    }
}