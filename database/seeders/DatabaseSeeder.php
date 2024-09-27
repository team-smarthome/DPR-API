<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // IntansiSeeder::class,
            // JabatanSeeder::class,
            // PalmDataSeeder::class,
            // FacialDataSeeder::class,
            // PegawaiSeeder::class,
            // RoleSeeder::class,
            // UsersSeeder::class,
            // PengunjungSeeder::class,
            // LokasiSeeder::class,
            // ZonaSeeder::class,
            // DeviceTypeSeeder::class,
            DeviceSeeder::class,
        ]);
    }
}
