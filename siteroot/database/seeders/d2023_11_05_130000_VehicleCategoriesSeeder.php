<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;

class d2023_11_05_130000_VehicleCategoriesSeeder extends Seeder
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
                'id' => 11,
                'code' => 'bike',
                'description' => 'Мопеды и мотоциклы',
                //'created_at' => Carbon::now('UTC')
            ],
            [
                'id' => 12,
                'code' => 'bus',
                'description' => 'Автобусы (более 8пасс)',
                //'created_at' => Carbon::now('UTC')
            ],            [
                'id' => 13,
                'code' => 'tractor',
                'description' => 'Тракторы',
                //'created_at' => Carbon::now('UTC')
            ],

        );

        foreach ($rows as $row) {
            DB::table('vehicle_categories')->insert($row);
        }
    }
}
