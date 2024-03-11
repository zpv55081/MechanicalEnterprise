<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class d2024_03_05_130000_UnitsSeeder extends Seeder
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
                'designation' => 'шт',
                'description' => 'штуки',
                'created_at' => Carbon::now('UTC')
            ],
            [
                'id' => 2,
                'designation' => 'кг',
                'description' => 'килограммы',
                'created_at' => Carbon::now('UTC')
            ],            [
                'id' => 3,
                'designation' => 'л',
                'description' => 'литры',
                'created_at' => Carbon::now('UTC')
            ],            [
                'id' => 4,
                'designation' => 'м',
                'description' => 'метры',
                'created_at' => Carbon::now('UTC')
            ],            [
                'id' => 6,
                'designation' => 'м2',
                'description' => 'квадр.метры',
                'created_at' => Carbon::now('UTC')
            ],            [
                'id' => 7,
                'designation' => 'н/ч',
                'description' => 'нормочасы',
                'created_at' => Carbon::now('UTC')
            ],

        );

        foreach ($rows as $row) {
            DB::table('units')->insert($row);
        }
    }
}
