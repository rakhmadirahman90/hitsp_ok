<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = ['nama','peran','foto','divisi_id','aktif'];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
