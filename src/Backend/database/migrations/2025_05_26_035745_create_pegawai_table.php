<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('idPegawai')->unique();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('jabatan');
            $table->string('noHp')->nullable();
            $table->string('status')->default('aktif'); // misal: aktif/nonaktif
            $table->timestamps();
            $table->softDeletes(); // menambahkan kolom deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_pegawais');
    }
};