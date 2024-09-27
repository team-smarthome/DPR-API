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
        Schema::create('device', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_device', 100)->nullable(false);
            $table->uuid('zona_id')->nullable(false);
            $table->uuid('dtype', 100)->nullable(false);
            $table->string('ip_address', 100)->nullable(false);
            $table->string('mac_address', 100)->nullable(false);
            $table->string('rtsp_url', 255)->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zona_id')->references('id')->on('zona');
            $table->foreign('dtype')->references('id')->on('device_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device');
    }
};
