<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengunjungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengunjung = [
            [
                'id' => "0192325d-57b8-78b5-987b-1c5454de8658",
                'nik' => '1234567890',
                'nama_pengunjung' => 'Prima',
                'jenis_kelamin' => 'L',
                'is_active' => 0,
                'email' => 'prima@transforme.com',
                'phone' => '081234567890',
                'palm_data_id' => '01923254-08fe-7b24-ad8e-15f121c9ce43',
                'face_id' => '01923255-3ca3-7b26-9b74-eeec864c67e8',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('pengunjung')->insert($pengunjung);
    }
}
