<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanEmailPribadiTable extends Migration
{
    public function up()
    {
        Schema::create('permohonan_email_pribadi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relasi dengan user
            $table->string('nama_lengkap');
            $table->enum('jenis_pemohon', ['pegawai','mahasiswa']);
            $table->string('fakultas');
            $table->string('jurusan');
            $table->string('jabatan')->nullable();
            $table->string('nomor_identitas');
            $table->string('no_telp')->nullable();
            $table->string('email_alternatif');
            $table->string('file_identitas'); // path file
            $table->string('email_name');
            $table->string('email_domain');
            $table->string('rek_nama')->nullable();
            $table->string('rek_identitas')->nullable();
            $table->string('rek_fakultas')->nullable();
            $table->string('rek_email')->nullable();
            $table->enum('status', ['pending','disetujui','ditolak'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_email_pribadi');
    }
}
