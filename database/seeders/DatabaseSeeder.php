<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => '101010',
            'email' => 'tik@ith.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
