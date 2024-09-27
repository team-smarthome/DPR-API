<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            [
                'id' => "0192325a-6388-72aa-8c7d-1a819a701f2f",
                'nama_role' => 'Ketua',
                'is_suspend' => 0,
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];
        DB::table('role')->insert($role);
    }
}
