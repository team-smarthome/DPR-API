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
    Schema::create('recording_plan', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('user_id')->nullable(false);
      $table->string('nama_recording_plan', 100)->nullable(false);
      $table->string('template');
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('user_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('recording_plan');
  }
};
