<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasOperator extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_operator';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'jenis',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}