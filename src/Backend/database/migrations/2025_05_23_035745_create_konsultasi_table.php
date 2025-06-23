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
        Schema::create('data_konsultasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('nama_korban')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('alamat')->nullable();
            $table->dateTime('waktu_kejadian')->nullable();
            $table->string('kasus')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('saksi')->nullable();
            $table->string('status')->default('diproses');
            $table->string('lampiran')->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_konsultasi');
    }
};