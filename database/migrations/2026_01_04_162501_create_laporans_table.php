<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            $table->string('ticket_no')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('nama_pengirim');
            $table->string('status_pengirim');

            $table->string('judul');
            $table->string('kategori');
            $table->string('tingkat_urgensi');
            $table->string('lokasi');

            $table->text('deskripsi');
            $table->string('bukti')->nullable();

            $table->date('tanggal');
            $table->string('status')->default('Menunggu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};