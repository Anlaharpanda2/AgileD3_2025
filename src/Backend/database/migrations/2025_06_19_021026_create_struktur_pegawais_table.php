<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_pegawais', function (Blueprint $table) {
            $table->integer('idPegawai')->primary(); // Gunakan sebagai Primary Key
            $table->string('nama');
            $table->string('alamat');
            $table->string('email')->unique();
            $table->string('jabatan');
            $table->string('noHp');
            $table->enum('status', ['aktif', 'nonaktif', 'cuti'])->default('aktif');
            $table->timestamps(); // createdAt & updatedAt
            $table->softDeletes(); // fitur "sampah"
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_pegawais');
    }
};
