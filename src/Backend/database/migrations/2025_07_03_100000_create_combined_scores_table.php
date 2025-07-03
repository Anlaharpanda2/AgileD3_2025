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
        Schema::create('combined_scores', function (Blueprint $table) {
            $table->id();
            $table->string('user_nik')->unique();
            $table->string('user_name');
            $table->integer('pretest_score')->nullable();
            $table->integer('posttest_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combined_scores');
    }
};
