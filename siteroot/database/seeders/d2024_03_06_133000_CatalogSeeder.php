<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class d2024_03_06_133000_CatalogSeeder extends Seeder
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
                "id" => 1,
                "name" => "Масло Shell 5w30",
                "vendor_code" => "5-w-30",
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 2,
                "name" => "Фильтр масляный (диз.)",
                "vendor_code" => "232323",
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 3,
                "name" => "Фильтр масляный (бенз.)",
                "vendor_code" => "010101",
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 4,
                "name" => "Спрей для дроссельной заслонки",
                "vendor_code" => "karb01",
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 5,
                "name" => "Осмотровые работы",
                "vendor_code" => null,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 6,
                "name" => "Замена масла в ДВС",
                "vendor_code" => null,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 7,
                "name" => "Регулировочные работы",
                "vendor_code" => null,
                'created_at' => Carbon::now('UTC')
            ],
            [
                "id" => 8,
                "name" => "Антифриз (-40) красный",
                "vendor_code" => "redone",
                'created_at' => Carbon::now('UTC')
            ]
        ];

        foreach ($rows as $row) {
            DB::table('catalog')->insert($row);
        }
    }
}
