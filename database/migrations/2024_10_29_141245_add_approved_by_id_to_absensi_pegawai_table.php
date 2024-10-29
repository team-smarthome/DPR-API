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
    Schema::table('absensi_pegawai', function (Blueprint $table) {
      $table->uuid('approved_by_id')->nullable();


      $table->foreign('approved_by_id')->references('id')->on('pegawai');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('absensi_pegawai', function (Blueprint $table) {

      $table->dropForeign(['approved_by_id']);


      $table->dropColumn('approved_by_id');
    });
  }
};
