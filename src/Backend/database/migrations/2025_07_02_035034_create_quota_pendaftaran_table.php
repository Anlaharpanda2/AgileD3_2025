<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotaPendaftaranTable extends Migration
{
    public function up()
    {
        Schema::create('quota_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true); // true = buka, false = tutup
            $table->unsignedInteger('quota')->default(0); // jumlah quota pendaftaran
            $table->timestamps(); // jika tidak ingin pakai, hapus baris ini
        });
    }

    public function down()
    {
        Schema::dropIfExists('quota_pendaftaran');
    }
}
