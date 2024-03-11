<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class d2024_03_06_180000_MaintenanceSpecificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                "id" => 3,
                "maintenance_kinds_code" => "so",
                "vehicle_categories_id" => 12,
                "catalog_id" => 5,
                "quantity" => 0.5,
                "units_id" => 7,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 4,
                "maintenance_kinds_code" => "so",
                "vehicle_categories_id" => 12,
                "catalog_id" => 7,
                "quantity" => 0.5,
                "units_id" => 7,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 5,
                "maintenance_kinds_code" => "so",
                "vehicle_categories_id" => 12,
                "catalog_id" => 6,
                "quantity" => 1.2,
                "units_id" => 7,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 6,
                "maintenance_kinds_code" => "so",
                "vehicle_categories_id" => 12,
                "catalog_id" => 1,
                "quantity" => 10.0,
                "units_id" => 3,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 7,
                "maintenance_kinds_code" => "so",
                "vehicle_categories_id" => 12,
                "catalog_id" => 2,
                "quantity" => 2.0,
                "units_id" => 1,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 8,
                "maintenance_kinds_code" => "eo",
                "vehicle_categories_id" => 12,
                "catalog_id" => 5,
                "quantity" => 0.2,
                "units_id" => 1,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 9,
                "maintenance_kinds_code" => "eo",
                "vehicle_categories_id" => 13,
                "catalog_id" => 5,
                "quantity" => 0.3,
                "units_id" => 1,
                'created_at' => Carbon::now('UTC')
            ]
        ];

        foreach ($rows as $row) {
            DB::table('maintenance_specifications')->insert($row);
        }
    }
}
