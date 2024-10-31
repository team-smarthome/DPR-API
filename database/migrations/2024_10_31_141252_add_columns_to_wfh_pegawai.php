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
    Schema::table('wfh_pegawai', function (Blueprint $table) {
      $table->string('keterangan', 100)->nullable();
      $table->string('status', 100)->nullable(false);
      $table->string('image_url', 100)->nullable(false);
      $table->uuid('approved_by_id')->nullable();

      $table->foreign('approved_by_id')->references('id')->on('pegawai');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('wfh_pegawai', function (Blueprint $table) {
      $table->dropColumn('keterangan');
      $table->dropColumn('status');
      $table->dropColumn('image_url');
      $table->dropForeign(['approved_by_id']);
      $table->dropColumn('approved_by_id');
    });
  }
};
