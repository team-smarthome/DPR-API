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
      // Remove the 'is_wfh' column
      $table->dropColumn('is_wfh');

      // Add the 'keterangan' column with a max length of 100 characters
      $table->string('keterangan', 100)->nullable();
      $table->string('status', 100)->nullable();
      $table->string('jenis', 100)->nullable();

      // Add 'waktu_mulai' and 'waktu_selesai' columns with datetime type
      $table->dateTime('waktu_mulai')->nullable();
      $table->dateTime('waktu_selesai')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('absensi_pegawai', function (Blueprint $table) {
      // Re-add the 'is_wfh' column as tinyInteger if rollback is needed
      $table->tinyInteger('is_wfh')->unsigned()->nullable(false);

      // Remove the 'keterangan' column
      $table->dropColumn('keterangan');

      // Remove the 'status' column
      $table->dropColumn('status');

      // Remove the 'jenis' column
      $table->dropColumn('jenis');


      // Remove 'waktu_mulai' and 'waktu_selesai' columns
      $table->dropColumn(['waktu_mulai', 'waktu_selesai']);
    });
  }
};
