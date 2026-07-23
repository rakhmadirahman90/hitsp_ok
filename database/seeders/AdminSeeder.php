<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'upttik26@gmail.com',
            ],
            [
                'name'     => 'Superadmin',
                'username' => '101010',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
