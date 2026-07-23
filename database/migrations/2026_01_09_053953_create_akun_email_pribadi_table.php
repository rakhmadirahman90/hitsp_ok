<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun_email_pribadi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permohonan_id');
            $table->string('nama_akun');
            $table->string('password'); // bisa dihash jika perlu
            $table->timestamps();

            // relasi ke permohonan
            $table->foreign('permohonan_id')
                  ->references('id')
                  ->on('permohonan_email_pribadi')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun_email_pribadi');
    }
};
