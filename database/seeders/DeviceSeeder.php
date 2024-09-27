<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $device = [
            [
                'id' => "01923265-38f5-7c00-b447-a0e7304fcef7",
                'nama_device' => 'Kamera 1',
                'zona_id' => '0192325a-6388-72aa-8c7d-1a819a701f2f',
                'dtype' => '01923264-9ed9-7a90-a6b2-5aa8ecf94f40',
                'ip_address' => '192.168.2.1',
                'mac_address' => '00:0a:95:9d:68:16',
                'rtsp_url' => 'rtsp://rtsp_server:554',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
    }
}
