<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
        {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->enum('type', ['panduan', 'faq']); // Jenis
                $table->string('question'); // Pertanyaan
                $table->text('answer');     // Jawaban
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
