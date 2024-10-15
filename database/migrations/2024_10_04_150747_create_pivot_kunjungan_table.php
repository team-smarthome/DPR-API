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
        Schema::create('pivot_kunjungan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kunjungan_id'); 
            $table->uuid('pengunjung_id'); 
            $table->timestamps();

            $table->foreign('kunjungan_id')->references('id')->on('kunjungan')->cascadeOnDelete();
            $table->foreign('pengunjung_id')->references('id')->on('pengunjung')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pivot_kunjungan');
    }
};
