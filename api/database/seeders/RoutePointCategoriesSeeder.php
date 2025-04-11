<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutePointCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('route_point_categories')->insert([
            [
                "name" => "Погрузка"
            ],
            [
                "name" => "Разгрузка"
            ],
        ]);
    }
}
