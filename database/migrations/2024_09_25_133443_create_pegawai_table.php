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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_pegawai', 100)->nullable(false);
            $table->string('jenis_kelamin', 100)->nullable(false);
            $table->integer('is_active')->nullable(false);
            $table->uuid('jabatan_id')->nullable(false);
            $table->string('email', 100)->nullable(false);
            $table->string('phone', 100)->nullable(false);
            $table->uuid('palm_data_id')->nullable(false);
            $table->uuid('face_id')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jabatan_id')->references('id')->on('jabatan');
            $table->foreign('palm_data_id')->references('id')->on('palm_data');
            $table->foreign('face_id')->references('id')->on('facial_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
