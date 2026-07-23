<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingAccess extends Model
{
    use HasFactory;

    protected $table = 'hosting_access';

    protected $fillable = [
        'sub_domain_id',
        'ip_server',
        'ssh_user',      // Pemetaan dari input user_ssh
        'ssh_password',
        'db_name',       // Pemetaan dari input database_name
        'db_user',       // Pemetaan dari input database_user
        'db_password',   // <--- BARU: WAJIB DITAMBAHKAN AGAR PASSWORD DATABASE BISA TERSIMPAN
        'app_path',      // Pemetaan dari input lokasi_aplikasi
    ];

    /**
     * Relasi ke tabel sub_domains
     * 1 hosting_access milik 1 subdomain
     */
    public function subDomain()
    {
        return $this->belongsTo(SubDomain::class, 'sub_domain_id');
    }
}