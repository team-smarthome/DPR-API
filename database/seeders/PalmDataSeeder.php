<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PalmDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $palm_data = [
            [
                'id' => "01923254-08fe-7b24-ad8e-15f121c9ce43",
                'vein_pattern' => 'Kelurahan',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('palm_data')->insert($palm_data);
    }
}
