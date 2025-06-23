<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_berita', function (Blueprint $table) {
            $table->id(); 
            $table->string('judul'); 
            $table->text('isi'); 
            $table->string('jenis_konten')->nullable(); 
            $table->string('foto')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('data_berita');
    }
};
