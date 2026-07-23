<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotspot_users', function (Blueprint $table) {
            $table->id();
            
            // relasi ke user login
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->json('akses'); // checkbox array
            $table->string('nama_lengkap');
            $table->string('jabatan');
            $table->string('nip');
            $table->string('akun_hotspot');
            $table->string('no_telepon');
            $table->string('email');
            $table->string('nama_hotspot');
            $table->string('pj_nama');
            $table->string('pj_nip');
            $table->string('pj_jabatan');
            $table->string('pj_telepon');
            $table->boolean('persetujuan'); // checkbox jadi boolean

            // TAMBAHAN WAJIB AGAR MUNCUL DI RIWAYAT
            $table->string('status')->default('pending'); 
            $table->string('layanan')->default('Hotspot');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotspot_users');
    }
};