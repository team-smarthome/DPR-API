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
    Schema::create('user_pengunjung', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('pengunjung_id')->nullable(false);
      $table->string('username', 100)->nullable(false);
      $table->string('password', 255)->nullable(false);
      $table->uuid('role_id')->nullable(false);
      $table->tinyInteger('is_suspend')->nullable(false)->unsigned();
      $table->datetime('last_login')->nullable(true);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('pengunjung_id')->references('id')->on('pengunjung');
      $table->foreign('role_id')->references('id')->on('role');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_pengunjung');
  }
};
