<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zona = [
            [
                'id' => "01923262-0f8c-7264-b40b-0ee97bbb9893",
                'nama_zona' => 'zona merah',
                'jenis_zona' => 'zona merah',
                'lokasi_id' => '01923260-8e32-7e8c-b01d-c83a098e42c6',
                'panjang' => 10.0,
                'lebar' => 10.0,
                'posisi_X' => 10.0,
                'posisi_Y' => 10.0,
                'parent_id' => '01923263-6184-711d-9dbc-6de51e41e73d',
                'jenis_restriksi' => 'Pembatasan',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('zona')->insert($zona);
    }
}
