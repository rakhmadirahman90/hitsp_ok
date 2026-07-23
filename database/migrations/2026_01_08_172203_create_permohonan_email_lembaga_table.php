<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('permohonan_email_lembaga', function (Blueprint $table) {
            $table->id();
            $table->string('nama_institusi');
            $table->string('nama_kegiatan')->nullable();
            $table->string('nama_akun');
            $table->string('email_alternatif');
            $table->string('nama_teknis')->nullable();
            $table->string('nip_nik_nim_teknis')->nullable();
            $table->string('jabatan_teknis')->nullable();
            $table->string('status_teknis')->nullable();
            $table->string('telp_teknis')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void {
        Schema::dropIfExists('permohonan_email_lembaga');
    }
};
