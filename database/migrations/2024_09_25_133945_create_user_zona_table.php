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
        Schema::create('user_zona', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pegawai_id')->nullable(false);
            $table->uuid('pengunjung_id')->nullable(false);
            $table->uuid('zona_id')->nullable(false);
            $table->integer('is_suspend')->nullable(false);
            $table->dateTime('waktu_mulai')->nullable(true);
            $table->dateTime('waktu_berakhir')->nullable(true);
            $table->string('keterangan', 255)->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pegawai_id')->references('id')->on('pegawai');
            $table->foreign('pengunjung_id')->references('id')->on('pengunjung');
            $table->foreign('zona_id')->references('id')->on('zona');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_zona');
    }
};
