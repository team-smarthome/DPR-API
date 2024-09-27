<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawai = [
            [
                'id' => "01923257-3926-7988-9803-024088676703",
                'nama_pegawai' => 'Dandan',
                'jenis_kelamin' => 'L',
                'is_active' => 0,
                'jabatan_id' => '01923250-d032-7c64-aee4-44593f3d145c',
                'email' => 'dandan@gmail.com',
                'phone' => '081234567890',
                'palm_data_id' => '01923254-08fe-7b24-ad8e-15f121c9ce43',
                'face_id' => '01923255-3ca3-7b26-9b74-eeec864c67e8',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('pegawai')->insert($pegawai);
    }
}
