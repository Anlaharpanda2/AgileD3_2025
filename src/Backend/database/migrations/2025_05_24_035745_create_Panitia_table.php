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
        Schema::create('data_panitia', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('email')->unique();
            $table->string('jabatan');
            $table->string('nama_panitia');
            $table->string('no_hp');
            $table->string('foto')->nullable(); // Path foto di storage/public
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_panitia');
    }
};