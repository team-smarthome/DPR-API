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
    Schema::create('rent_smart_locker', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('pegawai_id')->nullable(false);
      $table->uuid('pengunjung_id')->nullable(false);
      $table->uuid('smart_locker_compartment_id')->nullable(false);
      $table->tinyInteger('is_suspend')->nullable(false)->unsigned();
      $table->dateTime('waktu_mulai')->nullable(false);
      $table->dateTime('waktu_berakhir')->nullable(false);
      $table->string('keterangan', 100)->nullable(false);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('smart_locker_compartment_id')->references('id')->on('smart_locker_compartment');
      $table->foreign('pengunjung_id')->references('id')->on('pengunjung');
      $table->foreign('pegawai_id')->references('id')->on('pegawai');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('rent_smart_locker');
  }
};
