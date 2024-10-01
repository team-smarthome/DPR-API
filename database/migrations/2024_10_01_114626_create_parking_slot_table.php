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
    Schema::create('parking_slot', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('zona_id')->nullable(false);
      $table->string('nama_parking_slot', 100)->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('zona_id')->references('id')->on('zona');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('parking_slot');
  }
};
