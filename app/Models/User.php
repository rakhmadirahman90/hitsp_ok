<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
	'institution',
        'role',
	'institution_domain',
        'status'
    ];

    protected $hidden = [
        'password',
    ];
}