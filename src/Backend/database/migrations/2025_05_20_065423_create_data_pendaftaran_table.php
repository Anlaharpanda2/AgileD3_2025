<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('jenis_bimtek');
            $table->date('kegiatan_dimulai')->nullable();
            $table->date('kegiatan_berakhir')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->unsignedInteger('angkatan')->nullable();
            $table->string('tempat_tanggal_lahir');
            $table->string('pendidikan');
            $table->string('status');
            $table->text('alamat');
            $table->string('jenis_usaha');
            $table->string('penghasilan_perbulan');
            $table->string('nomor_telefon');
            $table->string('status_pendaftaran')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->index('nik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_pendaftaran');
    }
};
