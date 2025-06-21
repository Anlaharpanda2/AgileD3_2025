<?php
// database/migrations/2025_06_10_000002_create_konsultasi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->text('alamat');
            $table->string('deskripsi_data_konsultasi');
            $table->unsignedInteger('id_konsultasi');
            $table->string('jenis_kelamin');
            $table->string('kasus');
            $table->string('nama');
            $table->string('nama_korban');
            $table->unsignedBigInteger('no_hp');
            $table->string('saksi');
            $table->enum('status', ['pending','selesai','ditolak']); // adjust statuses as needed
            $table->unsignedInteger('umur');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
