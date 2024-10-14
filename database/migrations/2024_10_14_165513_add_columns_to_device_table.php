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
    Schema::table('device', function (Blueprint $table) {
      $table->string('url_cp_device')->nullable();
      $table->string('username_cp_device')->nullable();
      $table->string('password_cp_device')->nullable();
      $table->string('timezone_cp_device')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('device', function (Blueprint $table) {
      $table->dropColumn(['url_cp_device', 'username_cp_device', 'password_cp_device', 'timezone_cp_device']);
    });
  }
};
