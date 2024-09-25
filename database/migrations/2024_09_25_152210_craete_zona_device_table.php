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
        Schema::create('zona_device', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('zona_id')->nullable(false);
            $table->uuid('device_id')->nullable(false);
            $table->integer('point_X')->nullable(false);
            $table->integer('point_Y')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zona_id')->references('id')->on('zona');
            $table->foreign('device_id')->references('id')->on('device');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_device');
    }
};
