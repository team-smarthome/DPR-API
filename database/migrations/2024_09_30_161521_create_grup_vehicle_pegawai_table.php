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
    Schema::create('grup_vehicle_pegawai', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('ketua_grup')->nullable(false);
      $table->uuid('nama_grup_vehicle_pegawai')->nullable(false);
      $table->softDeletes();
      $table->timestamps();

      $table->foreign('ketua_grup')->references('id')->on('pegawai');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('grup_vehicle_pegawai_');
  }
};
