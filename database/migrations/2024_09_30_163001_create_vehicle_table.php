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
    Schema::create('vehicle', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('pegawai_id')->nullable(false);
      $table->uuid('pengunjung_id')->nullable(false);
      $table->string('plat_nomor', 100)->nullable(false);
      $table->string('image_url', 100)->nullable(false);
      $table->uuid('grup_vehicle_pegawai_id')->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('pegawai_id')->references('id')->on('pegawai');
      $table->foreign('pengunjung_id')->references('id')->on('pengunjung');
      $table->foreign('grup_vehicle_pegawai_id')->references('id')->on('grup_vehicle_pegawai');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vehicle');
  }
};
