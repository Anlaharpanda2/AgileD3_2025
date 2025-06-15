<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users_masyarakat', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('tempat_tanggal_lahir');
            $table->string('jenis_bimtek')->nullable();
            $table->date('kegiatan_dimulai')->nullable();
            $table->date('kegiatan_berakhir')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->unsignedInteger('angkatan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->enum('status', ['kawin', 'lajang', 'janda'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->string('penghasilan_perbulan')->nullable();
            $table->string('nomor_telefon')->nullable();
            $table->string('status_pendaftaran')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users_masyarakat');
    }
};
