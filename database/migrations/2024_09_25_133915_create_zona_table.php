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
        Schema::create('zona', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_zona', 100)->nullable(false);
            $table->string('jenis_zona', 100)->nullable(true);
            $table->uuid('lokasi_id')->nullable(false);
            $table->float('panjang')->nullable(true);
            $table->float('lebar')->nullable(true);
            $table->float('posisi_X')->nullable(true);
            $table->float('posisi_Y')->nullable(true);
            $table->uuid('parent_id')->nullable(true);
            $table->string('jenis_restriksi', 100)->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lokasi_id')->references('id')->on('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona');
    }
};
