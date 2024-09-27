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
    Schema::table('pegawai', function (Blueprint $table) {
      $table->uuid('role_id')->nullable(false)->after('face_id'); // Menambahkan kolom role_id
      $table->foreign('role_id')->references('id')->on('role'); // Menambahkan foreign key untuk role_id
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('pegawai', function (Blueprint $table) {
      $table->dropForeign(['role_id']); // Menghapus foreign key constraint
      $table->dropColumn('role_id'); // Menghapus kolom role_id
    });
  }
};
