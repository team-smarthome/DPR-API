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
    Schema::create('grup_kamera_tersimpan', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('device_id')->nullable(false);
      $table->uuid('kamera_tersimpan_id')->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('device_id')->references('id')->on('device');
      $table->foreign('kamera_tersimpan_id')->references('id')->on('kamera_tersimpan');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('grup_kamera_tersimpan');
  }
};
