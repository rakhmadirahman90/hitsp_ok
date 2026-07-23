<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Laporan extends Model
{
    use HasFactory;

    /**
     * PERBAIKAN VITAL: Berdasarkan screenshot phpMyAdmin Anda, 
     * nama tabel yang benar adalah 'laporans'.
     */
    protected $table = 'laporans'; 

    protected $fillable = [
        'ticket_no',
        'user_id',
        'nama_pengirim',
        'status_pengirim',
        'judul',
        'kategori',
        'tingkat_urgensi',
        'lokasi',
        'deskripsi',
        'bukti',
        'tanggal',
        'status'
    ];

    /**
     * Relasi ke Model User.
     * Menggunakan user_id sebagai foreign key.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor untuk memastikan URL bukti/gambar selalu benar.
     * Kode ini mengecek keberadaan file secara fisik di folder storage.
     */
    public function getBuktiUrlAttribute()
    {
        // Mengecek apakah kolom bukti ada isinya dan filenya benar-benar ada di disk public
        if ($this->bukti && Storage::disk('public')->exists($this->bukti)) {
            return asset('storage/' . $this->bukti);
        }
        
        // Return gambar default jika file tidak ditemukan atau kolom kosong
        return asset('img/no-image.png');
    }

    /**
     * KODE BARU: Boot method untuk otomatisasi Ticket Number & Default Status.
     * Ini akan dijalankan secara otomatis saat membuat data baru (store).
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($laporan) {
            // Otomatis buat Ticket Number unik jika kosong
            if (empty($laporan->ticket_no)) {
                $laporan->ticket_no = 'HITSP-' . strtoupper(Str::random(6)) . '-' . date('Y');
            }

            // Set default status ke 'Menunggu' sesuai struktur DB Anda jika tidak diisi
            if (empty($laporan->status)) {
                $laporan->status = 'Menunggu';
            }
        });
    }
}