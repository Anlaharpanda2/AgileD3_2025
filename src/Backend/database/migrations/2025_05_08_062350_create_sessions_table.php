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
<<<<<<<< HEAD:src/Backend/database/migrations/2025_05_06_053337_create_users_table.php
        Schema::create('masyarakat', function (Blueprint $table) {
========
        Schema::create('sessions', function (Blueprint $table) {
>>>>>>>> NadyaUS1105,US1106:src/Backend/database/migrations/2025_05_08_062350_create_sessions_table.php
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:src/Backend/database/migrations/2025_05_06_053337_create_users_table.php
        Schema::dropIfExists('users');
========
        Schema::dropIfExists('sessions');
>>>>>>>> NadyaUS1105,US1106:src/Backend/database/migrations/2025_05_08_062350_create_sessions_table.php
    }
};
