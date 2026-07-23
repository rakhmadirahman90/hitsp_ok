<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Fasilitas extends Model
{
    protected $fillable = ['nama'];

    public function gambar()
    {
        return $this->hasMany(FasilitasGambar::class);
    }

    // Kode baru: Otomatis hapus file fisik saat data di database dihapus
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($fasilitas) {
            foreach ($fasilitas->gambar as $g) {
                Storage::disk('public')->delete('fasilitas/' . $g->nama_file);
                $g->delete();
            }
        });
    }
}