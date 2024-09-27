<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $device_type = [
            [
                'id' => "01923264-9ed9-7a90-a6b2-5aa8ecf94f40",
                'nama' => 'Kamera',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('device_type')->insert($device_type);
    }
}
