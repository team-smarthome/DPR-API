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
      $table->renameColumn('waktu_mulai', 'waktu_masuk');

      $table->renameColumn('waktu_selesai', 'waktu_keluar');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('absensi_pegawai', function (Blueprint $table) {
      $table->renameColumn('waktu_masuk', 'waktu_mulai');

      $table->renameColumn('waktu_keluar', 'waktu_selesai');
    });
  }
};
