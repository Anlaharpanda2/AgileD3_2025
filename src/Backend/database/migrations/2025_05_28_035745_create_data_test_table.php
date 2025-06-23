<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_tests', function (Blueprint $table) {
            $table->id();
            $table->string('soal');
            $table->enum('tipe', ['pretest', 'posttest']);
            $table->string('opsi_a');
            $table->string('opsi_b');
            $table->string('opsi_c');
            $table->string('opsi_d');
            $table->enum('jawaban_benar', ['a', 'b', 'c', 'd']);
            $table->string('kategori')->nullable();
            $table->unsignedInteger('nomor_soal'); 
            $table->string('kelompok_soal');
            $table->softDeletes(); 
            $table->timestamps();  
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_tests');
    }
};
