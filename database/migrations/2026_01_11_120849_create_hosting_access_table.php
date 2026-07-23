<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hosting_access', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel sub_domains
            $table->foreignId('sub_domain_id')
                  ->constrained('sub_domains')
                  ->cascadeOnDelete();

            // ================= DATA SERVER =================
            $table->string('ip_server')->nullable();
            $table->string('ssh_user')->nullable();
            $table->string('ssh_password')->nullable();

            // ================= DATABASE =================
            $table->string('db_name')->nullable();
            $table->string('db_user')->nullable();
            $table->string('db_password')->nullable();

            // ================= LOKASI APLIKASI =================
            $table->string('app_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_access');
    }
};
