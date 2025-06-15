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
            $table->string('photo')->nullable();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->foreign('nik')->references('nik')->on('users_masyarakat')->onDelete('cascade');
            $table->string('jenis_bimtek');
            $table->date('kegiatan_dimulai')->nullable();
            $table->date('kegiatan_berakhir')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->unsignedInteger('angkatan')->nullable();
            $table->string('tempat_tanggal_lahir');
            $table->string('pendidikan');
            $table->string('status');
            $table->text('alamat');
            $table->string('jenis_usaha');
            $table->string('penghasilan_perbulan');
            $table->string('nomor_telefon');
            $table->timestamps();
            $table->index('nik');
        });

        // Trigger AFTER INSERT untuk update users_masyarakat jika nik sudah ada
        DB::unprepared(<<<'SQL'
CREATE TRIGGER trg_after_insert_data_pendaftaran
AFTER INSERT ON data_pendaftaran
FOR EACH ROW
BEGIN
  IF EXISTS (SELECT 1 FROM users_masyarakat WHERE nik = NEW.nik) THEN
    UPDATE users_masyarakat
    SET
      nama = IF(NEW.nama IS NOT NULL AND NEW.nama != '', NEW.nama, nama),
      jenis_bimtek = IF(NEW.jenis_bimtek IS NOT NULL AND NEW.jenis_bimtek != '', NEW.jenis_bimtek, jenis_bimtek),
      kegiatan_dimulai = IF(NEW.kegiatan_dimulai IS NOT NULL, NEW.kegiatan_dimulai, kegiatan_dimulai),
      kegiatan_berakhir = IF(NEW.kegiatan_berakhir IS NOT NULL, NEW.kegiatan_berakhir, kegiatan_berakhir),
      tempat_kegiatan = IF(NEW.tempat_kegiatan IS NOT NULL AND NEW.tempat_kegiatan != '', NEW.tempat_kegiatan, tempat_kegiatan),
      angkatan = IF(NEW.angkatan IS NOT NULL, NEW.angkatan, angkatan),
      tempat_tanggal_lahir = IF(NEW.tempat_tanggal_lahir IS NOT NULL AND NEW.tempat_tanggal_lahir != '', NEW.tempat_tanggal_lahir, tempat_tanggal_lahir),
      pendidikan = IF(NEW.pendidikan IS NOT NULL AND NEW.pendidikan != '', NEW.pendidikan, pendidikan),
      status = IF(NEW.status IS NOT NULL AND NEW.status != '', NEW.status, status),
      alamat = IF(NEW.alamat IS NOT NULL AND NEW.alamat != '', NEW.alamat, alamat),
      jenis_usaha = IF(NEW.jenis_usaha IS NOT NULL AND NEW.jenis_usaha != '', NEW.jenis_usaha, jenis_usaha),
      penghasilan_perbulan = IF(NEW.penghasilan_perbulan IS NOT NULL AND NEW.penghasilan_perbulan != '', NEW.penghasilan_perbulan, penghasilan_perbulan),
      nomor_telefon = IF(NEW.nomor_telefon IS NOT NULL AND NEW.nomor_telefon != '', NEW.nomor_telefon, nomor_telefon),
      updated_at = NOW()
    WHERE nik = NEW.nik;
  END IF;
END;
SQL);
    }

    public function down(): void
    {
        // Drop trigger sebelum drop table
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_insert_data_pendaftaran;');
        Schema::dropIfExists('data_pendaftaran');
    }
};
