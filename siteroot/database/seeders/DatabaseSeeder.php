<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
/*             d2023_11_05_130000_VehicleCategoriesSeeder::class,//
            d2024_03_05_130000_UnitsSeeder::class,//
            d2024_03_06_133000_CatalogSeeder::class,//
            d2024_03_06_160000_MaintenanceKindsSeeder::class,//
            d2024_03_06_180000_MaintenanceSpecificationsSeeder::class,// */
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
