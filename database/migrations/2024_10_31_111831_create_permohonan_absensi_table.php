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
    Schema::create('permohonan_absensi', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('pegawai_id')->nullable(false);
      $table->string('nama_permohonan')->nullable(false);
      $table->string('image_lampiran', 100)->nullable(false);
      $table->string('status')->nullable(true);
      $table->dateTime('waktu_mulai')->nullable(false);
      $table->dateTime('waktu_selesai')->nullable(false);
      $table->integer('jumlah_hari')->nullable(false);
      $table->string('keterangan', 100)->nullable(true);
      $table->uuid('approved_by_id')->nullable(true);
      $table->string('jenis_permohonan', 100)->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('pegawai_id')->references('id')->on('pegawai');
      $table->foreign('approved_by_id')->references('id')->on('pegawai');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('permohonan_absensi');
  }
};
