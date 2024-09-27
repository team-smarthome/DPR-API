<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = [
            [
                'id' => "01923250-d032-7c64-aee4-44593f3d145c",
                'nama_jabatan' => 'Kelurahan',
                'instansi_id' => '0192324f-96dc-72dc-b294-9b10b2173332',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('jabatan')->insert($jabatan);
    }
}
