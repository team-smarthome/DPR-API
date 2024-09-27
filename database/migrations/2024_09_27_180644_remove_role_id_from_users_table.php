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
    Schema::table('users', function (Blueprint $table) {
      $table->dropForeign(['role_id']); // Hapus foreign key constraint jika ada
      $table->dropColumn('role_id'); // Hapus kolom role_id
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->uuid('role_id')->nullable(false); // Tambahkan kembali kolom role_id
      $table->foreign('role_id')->references('id')->on('role'); // Tambahkan foreign key constraint
    });
  }
};
