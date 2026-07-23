<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // menautkan ke user
            $table->string('jenis_domain');
            $table->string('nama_organisasi');
            $table->string('nama_admin');
            $table->string('nip_admin');
            $table->string('alamat_kantor_admin');
            $table->string('alamat_rumah_admin');
            $table->string('telp_kantor_admin');
            $table->string('telp_rumah_admin');
            $table->string('email_admin');
            $table->string('nama_teknis');
            $table->string('nip_nim_teknis');
            $table->string('alamat_kantor_teknis');
            $table->string('alamat_rumah_teknis');
            $table->string('telp_kantor_teknis');
            $table->string('email_teknis');
            $table->string('nama_sub_domain');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_domains');
    }
};
