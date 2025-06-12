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
         Schema::create('soal_pre_post_tests', function (Blueprint $table) {
        $table->id();
        $table->enum('jenis', ['pretest', 'postest']);
        $table->text('pertanyaan');
        $table->json('pilihan'); // {"a":"Option A", "b":"Option B", ...}
        $table->string('jawaban_benar');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_pre_post_tests');
    }
};
