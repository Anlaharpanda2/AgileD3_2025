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
        Schema::create('posttest_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posttest_id')->constrained()->onDelete('cascade');
            $table->string('user_nik');
            $table->string('user_name');
            $table->integer('score');
            $table->integer('total_questions');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique(['posttest_id', 'user_nik']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posttest_scores');
    }
};
