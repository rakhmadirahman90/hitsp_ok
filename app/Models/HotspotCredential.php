<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotspotCredential extends Model
{
    protected $fillable = [
        'hotspot_user_id',
        'username_hotspot',
        'password_hotspot'
    ];

    public function hotspotUser()
    {
        return $this->belongsTo(HotspotUser::class);
    }
    public function credential()
{
    return $this->hasOne(HotspotCredential::class);
}

}

