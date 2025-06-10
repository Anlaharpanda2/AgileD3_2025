<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik');
            $table->string('jenis_bimtek');
            $table->date('kegiatan_dimulai');
            $table->date('kegiatan_berakhir');
            $table->string('tempat_kegiatan');
            $table->unsignedInteger('angkatan');
            $table->string('tempat_tanggal_lahir');
            $table->string('pendidikan');
            $table->enum('status', ['kawin', 'lajang', 'janda']);
            $table->text('alamat');
            $table->string('jenis_usaha');
            $table->string('penghasilan_perbulan');
            $table->string('nomor_telefon');
            $table->softDeletes();
            $table->timestamps();

            // Index untuk mempercepat pengecekan nik di trigger
            $table->index('nik');
        });

        // Trigger: Setelah insert ke data_pendaftaran, sinkron ke users_masyarakat
        DB::unprepared(<<<'SQL'
CREATE TRIGGER trg_after_insert_data_pendaftaran
AFTER INSERT ON data_pendaftaran
FOR EACH ROW
BEGIN
  IF NOT EXISTS (
    SELECT 1 FROM users_masyarakat WHERE nik = NEW.nik
  ) THEN
    INSERT INTO users_masyarakat (
      nama, nik, jenis_bimtek, kegiatan_dimulai,
      kegiatan_berakhir, tempat_kegiatan, angkatan,
      tempat_tanggal_lahir, pendidikan, status,
      alamat, jenis_usaha, penghasilan_perbulan,
      nomor_telefon, created_at, updated_at
    ) VALUES (
      NEW.nama, NEW.nik, NEW.jenis_bimtek, NEW.kegiatan_dimulai,
      NEW.kegiatan_berakhir, NEW.tempat_kegiatan, NEW.angkatan,
      NEW.tempat_tanggal_lahir, NEW.pendidikan, NEW.status,
      NEW.alamat, NEW.jenis_usaha, NEW.penghasilan_perbulan,
      NEW.nomor_telefon, NOW(), NOW()
    );
  END IF;
END;
SQL
        );

        // Trigger: Setelah delete di data_pendaftaran, hapus di users_masyarakat
        DB::unprepared(<<<'SQL'
CREATE TRIGGER trg_after_delete_data_pendaftaran
AFTER DELETE ON data_pendaftaran
FOR EACH ROW
BEGIN
  DELETE FROM users_masyarakat
    WHERE nik = OLD.nik;
END;
SQL
        );
    }

    public function down(): void
    {
        // Hapus trigger sebelum drop tabel
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_insert_data_pendaftaran;');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_delete_data_pendaftaran;');
        Schema::dropIfExists('data_pendaftaran');
    }
};
