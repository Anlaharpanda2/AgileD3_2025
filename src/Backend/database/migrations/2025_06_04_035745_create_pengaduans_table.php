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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->string('nik');
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->integer('umur');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('jenis_kasus');
            $table->string('kasus')->nullable();
            $table->text('deskripsi_laporan');
            $table->dateTime('waktu_kejadian');
            $table->string('nama_korban')->nullable();
            $table->string('saksi')->nullable();
            $table->enum('jenis_pengaduan', ['langsung', 'tidak langsung'])->default('langsung');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['dikirim', 'diproses', 'selesai'])->default('dikirim');
            $table->text('tanggapan')->nullable();
            $table->date('tanggal_pengaduan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};