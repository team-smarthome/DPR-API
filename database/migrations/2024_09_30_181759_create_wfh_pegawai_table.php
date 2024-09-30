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
    Schema::create('wfh_pegawai', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('pegawai_id')->nullable(false);
      $table->string('nama_wfh_pegawai')->nullable(false);
      $table->dateTime('waktu_mulai')->nullable(false);
      $table->dateTime('waktu_selesai')->nullable(false);
      $table->integer('jumlah_hari')->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('pegawai_id')->references('id')->on('pegawai');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('wfh_pegawai');
  }
};
