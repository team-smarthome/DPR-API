<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasi = [
            [
                'id' => "01923260-8e32-7e8c-b01d-c83a098e42c6",
                'nama_lokasi' => 'Cideng',
                'latitude' => '-6.1743',
                'longitude' => '106.8184',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('lokasi')->insert($lokasi);
    }
}
