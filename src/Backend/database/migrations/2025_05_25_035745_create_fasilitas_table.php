<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fasilitas');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('jumlah')->default(0);
            $table->string('status')->default('tersedia'); // contoh: tersedia, rusak, dipinjam
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_fasilitas');
    }
};