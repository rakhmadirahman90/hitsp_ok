<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hotspot_credentials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hotspot_user_id')
                  ->constrained('hotspot_users')
                  ->onDelete('cascade');

            $table->string('username_hotspot'); // NIP / NIM
            $table->string('password_hotspot'); // password hotspot
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotspot_credentials');
    }
};
