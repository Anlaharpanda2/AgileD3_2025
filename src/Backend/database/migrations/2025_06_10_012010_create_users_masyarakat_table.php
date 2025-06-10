<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users_masyarakat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('jenis_bimtek');
            $table->date('kegiatan_dimulai');
            $table->date('kegiatan_berakhir');
            $table->string('tempat_kegiatan');
            $table->unsignedInteger('angkatan');
            $table->string('tempat_tanggal_lahir');
            $table->string('pendidikan');
            $table->enum('status', ['kawin', 'lajang', 'janda']);
            $table->text('alamat');
            $table->string('jenis_usaha');
            $table->string('penghasilan_perbulan');
            $table->string('nomor_telefon');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_masyarakat');
    }
};
