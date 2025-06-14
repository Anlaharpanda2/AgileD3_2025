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
         Schema::create('nilai_pre_post_tests', function (Blueprint $table) {
        $table->id();
        $table->string('nama_peserta');
        $table->enum('jenis', ['pretest', 'postest']);
        $table->integer('nilai');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_pre_post_tests');
    }
};
