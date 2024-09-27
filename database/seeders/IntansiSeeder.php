<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class IntansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instansi = [
            [
                'id' => "0192324f-96dc-72dc-b294-9b10b2123302",
                'nama_instansi' => 'Pemerintahan',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('instansi')->insert($instansi);
    }
}
