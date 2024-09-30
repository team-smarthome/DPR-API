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
    Schema::create('absensi_pegawai', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('pegawai_id')->nullable(false);
      $table->string('nama_absensi_pegawai')->nullable(false);
      $table->tinyInteger('is_wfh')->nullable(false)->unsigned();
      $table->string('image_url', 100)->nullable(false);
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
    Schema::dropIfExists('absensi_pegawai');
  }
};
