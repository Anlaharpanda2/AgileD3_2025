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
            Schema::create('pendaftar_baru', function (Blueprint $table) {
                $table->string('nik')->primary();
                $table->string('peserta');
                $table->string('tempat_tanggal_lahir');
                $table->enum('jenis_kelamin', ['L', 'P']);
                $table->text('alamat');
                $table->string('pendidikan');
                $table->string('pekerjaan');
                $table->string('email')->unique();
                $table->string('pelatihan');
                $table->date('tanggal_pelatihan');
                $table->string('tempat_pelatihan');
                $table->timestamps();
                $table->softDeletes();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar_baru');
    }
};
