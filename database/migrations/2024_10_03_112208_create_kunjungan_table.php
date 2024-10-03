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
    Schema::create('kunjungan', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('nama_kunjungan', 100)->nullable(false);
      $table->string('keperluan', 100)->nullable(false);
      $table->tinyInteger('is_approved')->nullable(false)->unsigned();
      $table->dateTime('approved_date')->nullable(true);
      $table->dateTime('reject_date')->nullable(true);
      $table->uuid('approved_by_id')->nullable(false);
      $table->dateTime('waktu_mulai')->nullable(false);
      $table->dateTime('waktu_berakhir')->nullable(false);
      $table->string('status', 100)->nullable(false);
      $table->uuid('pegawai_tujuan_id')->nullable(false);
      $table->uuid('pengunjung_id')->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('approved_by_id')->references('id')->on('pegawai');
      $table->foreign('pengunjung_id')->references('id')->on('pengunjung');
      $table->foreign('pegawai_tujuan_id')->references('id')->on('pegawai');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kunjungan');
  }
};
