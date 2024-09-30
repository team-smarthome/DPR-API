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
        Schema::create('grup_pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ketua_grup', 100)->nullable(false);
            $table->string('nama_grup_pegawai', 100)->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grup_pegawai');
    }
};
