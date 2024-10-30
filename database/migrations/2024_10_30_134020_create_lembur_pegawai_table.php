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
    Schema::create('lembur_pegawai', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('pegawai_id')->nullable(false);
      $table->string('nama_absensi_pegawai')->nullable(false);
      $table->string('jenis', 100)->nullable(false);
      $table->string('image_url', 100)->nullable(false);
      $table->string('status')->nullable(true);
      $table->dateTime('waktu_masuk')->nullable(false);
      $table->dateTime('waktu_keluar')->nullable(false);
      $table->string('keterangan', 100)->nullable(true);
      $table->uuid('approved_by_id')->nullable(true);
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
    Schema::dropIfExists('lembur_pegawai');
  }
};
