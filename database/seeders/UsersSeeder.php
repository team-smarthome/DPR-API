<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => "019232b5-0219-76c1-bb95-3c4988c0e496",
                'pegawai_id' => "01923257-3926-7988-9803-024088676703",
                'username' => 'dandan',
                'password' => Hash::make('dandan1234'),
                'role_id' => "0192325a-6388-72aa-8c7d-1a819a701f2f",
                'is_suspend' => 0,
                'last_login' => Carbon::now(), 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ]
        ];
        DB::table('users')->insert($users);
    }
}
