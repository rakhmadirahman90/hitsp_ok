<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HotspotUser extends Model
{
    use HasFactory;

    /**
     * Nama tabel didefinisikan secara eksplisit sesuai database
     */
    protected $table = 'hotspot_users';

    /**
     * Definisi Konstanta Status 
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'akses',
        'nama_lengkap',
        'jabatan',
        'nip',
        'akun_hotspot',
        'no_telepon',
        'email',
        'nama_hotspot',
        'pj_nama',
        'pj_nip',
        'pj_jabatan',
        'pj_telepon',
        'persetujuan',
        'username_hotspot',
        'password_hotspot',
        'status', 
        'layanan',
        'alasan_tolak', 
    ];

    protected $casts = [
        'persetujuan' => 'integer', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default values awal untuk objek model baru
     */
    protected $attributes = [
        'status' => self::STATUS_PENDING,
        'persetujuan' => 0, 
    ];

    /**
     * BOOT MODEL: PERBAIKAN UTAMA
     * Menggunakan event 'creating' untuk memaksa nilai 0 sebelum INSERT ke database.
     * Ini akan menimpa (override) default value database jika database memaksa nilai 1.
     */
    protected static function booted()
    {
        static::creating(function ($hotspot) {
            // PAKSA NILAI 0: Mengabaikan input apapun atau bug default database
            $hotspot->persetujuan = 0;
            
            // Pastikan status juga konsisten sebagai pending
            $hotspot->status = self::STATUS_PENDING;
        });
    }

    // --- RELASI ---

    /**
     * Relasi ke user pengaju
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // --- SCOPES (Untuk Riwayat & Filter) ---

    /**
     * Scope untuk mengambil data berdasarkan user yang sedang login
     */
    public function scopeMine(Builder $query)
    {
        return $query->where('user_id', auth()->id());
    }

    // --- ACCESSORS & LOGIC ---

    /**
     * LOGIKA TAMPILAN STATUS:
     * Memperbaiki tampilan agar sinkron dengan nilai integer (0, 1, 2)
     */
    public function getStatusLabelAttribute()
    {
        switch ((int)$this->persetujuan) {
            case 1:
                return 'DISETUJUI'; // Muncul jika admin sudah memproses
            case 2:
                return 'DITOLAK';
            case 0:
            default:
                return 'MENUNGGU VERIFIKASI'; // Seharusnya ini yang muncul saat awal permohonan
        }
    }

    /**
     * Badge Color
     */
    public function getStatusColorAttribute()
    {
        switch ((int)$this->persetujuan) {
            case 1:
                return 'success';
            case 2:
                return 'danger';
            default:
                return 'warning';
        }
    }

    /**
     * Cek apakah sudah diproses oleh admin
     */
    public function isProcessed(): bool
    {
        return (int)$this->persetujuan !== 0;
    }

    /**
     * Format tampilan akses
     */
    public function getAksesFormattedAttribute()
    {
        return $this->akses ?? '-';
    }

    /**
     * Accessor untuk mendapatkan inisial Nama Lengkap
     */
    public function getInitialAttribute()
    {
        if (empty($this->nama_lengkap)) return '??';
        
        $words = explode(' ', $this->nama_lengkap);
        $initials = '';
        foreach ($words as $w) {
            $initials .= $w[0] ?? '';
        }
        return strtoupper(substr($initials, 0, 2));
    }
}