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
    Schema::create('vehicle_logs', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('vehicle_id')->nullable(false);
      $table->uuid('zona_id')->nullable(false);
      $table->boolean('access_granted')->nullable(false);
      $table->dateTime('access_time')->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('vehicle_id')->references('id')->on('vehicle');
      $table->foreign('zona_id')->references('id')->on('zona');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vehicle_logs');
  }
};
