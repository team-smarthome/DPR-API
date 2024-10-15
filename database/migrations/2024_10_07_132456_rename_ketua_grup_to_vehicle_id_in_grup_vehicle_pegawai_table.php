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
        Schema::table('grup_vehicle_pegawai', function (Blueprint $table) {
            $table->renameColumn('ketua_grup', 'vehicle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grup_vehicle_pegawai', function (Blueprint $table) {
            //
        });
    }
};
