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
    Schema::create('grup_parking_slot', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('vehicle_id')->nullable(false);
      $table->uuid('parking_slot_id')->nullable(false);
      $table->timestamps();
      $table->softDeletes();


      $table->foreign('vehicle_id')->references('id')->on('vehicle');
      $table->foreign('parking_slot_id')->references('id')->on('parking_slot');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('grup_parking_slot');
  }
};
