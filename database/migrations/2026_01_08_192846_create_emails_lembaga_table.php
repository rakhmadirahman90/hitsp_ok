<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emails_lembaga', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_akun');
            $table->string('nama_akun');
            $table->string('password_hash');
            $table->string('email_pemohon');
            $table->enum('status', ['Disetujui','Ditolak','Pending'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emails_lembaga');
    }
};
