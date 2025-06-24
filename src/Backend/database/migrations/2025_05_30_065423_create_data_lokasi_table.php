<?php
// database/migrations/2025_06_10_000001_create_data_pelatihan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_lokasi', function (Blueprint $table) {
          $table->id();
          $table->string('nama_lokasi');
          $table->text('alamat');
          $table->decimal('latitude', 10, 8);  // -90 to 90
          $table->decimal('longitude', 11, 8); // -180 to 180
          $table->timestamps();
      });
    }
    public function down(): void
    {
        Schema::dropIfExists('data_lokasi');
    }
};