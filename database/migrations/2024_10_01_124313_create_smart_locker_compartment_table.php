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
    Schema::create('smart_locker_compartment', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('device_id')->nullable(false);
      $table->integer('number');
      $table->tinyInteger('is_available')->nullable(false)->unsigned();
      $table->string('qr_image', 100)->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('device_id')->references('id')->on('device');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('smart_locker_compartment');
  }
};
