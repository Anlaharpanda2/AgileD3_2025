<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up()
    {
        Schema::create('data_nilai', function (Blueprint $table) {
            $table->id();
            $table->string('nik'); 
            $table->integer('pretest_score')->nullable();
            $table->integer('posttest_score')->nullable();
            $table->string('kategori')->nullable(); 
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('data_nilai');
    }
};