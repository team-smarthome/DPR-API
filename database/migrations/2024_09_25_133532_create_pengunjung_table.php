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
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nik', 100)->nullable(false);
            $table->string('nama_pengunjung', 100)->nullable(false);
            $table->string('jenis_kelamin', 10)->nullable(false);
            $table->integer('is_active')->nullable(true);
            $table->string('email', 100)->nullable(false);
            $table->string('phone', 100)->nullable(false);
            $table->uuid('palm_data_id')->nullable(false);
            $table->uuid('face_id')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('palm_data_id')->references('id')->on('palm_data');
            $table->foreign('face_id')->references('id')->on('facial_data');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengunjung');
    }
};
