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
    Schema::table('pivot_kunjungan', function (Blueprint $table) {
      // Tambahkan kolom deleted_at untuk soft deletes
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('pivot_kunjungan', function (Blueprint $table) {
      // Hapus kolom deleted_at saat rollback
      $table->dropSoftDeletes();
    });
  }
};
