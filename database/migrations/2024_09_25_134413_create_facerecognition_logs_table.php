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
        Schema::create('facerecognition_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('device_id')->nullable(false);
            $table->uuid('pegawai_id')->nullable(false);
            $table->uuid('pengunjung_id')->nullable(false);
            $table->boolean('access_granted')->nullable(false);
            $table->date('access_time')->nullable(false);
            $table->string('user_name', 100)->nullable(true);
            $table->text('face_capture')->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('device_id')->references('id')->on('device_type');
            $table->foreign('pegawai_id')->references('id')->on('pegawai');
            $table->foreign('pengunjung_id')->references('id')->on('pengunjung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facerecognition_logs');
    }
};
