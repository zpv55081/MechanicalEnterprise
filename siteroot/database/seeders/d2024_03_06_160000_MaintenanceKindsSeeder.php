<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class d2024_03_06_160000_MaintenanceKindsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = array(
            [
                'id' => 1,
                'code' => 'eo',
                'description' => 'Ежедневное обслуживание',
                'created_at' => Carbon::now('UTC')
            ],
            [
                'id' => 2,
                'code' => 'per',
                'description' => 'Интервальное обслуживание',
                'created_at' => Carbon::now('UTC')
            ],            [
                'id' => 3,
                'code' => 'so',
                'description' => 'Сезонное обслуживание',
                'created_at' => Carbon::now('UTC')
            ],

        );

        foreach ($rows as $row) {
            DB::table('maintenance_kinds')->insert($row);
        }
    }
}
