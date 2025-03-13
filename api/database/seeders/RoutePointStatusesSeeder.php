<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutePointStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('route_point_statuses')->insert([
            [
                "name" => "Ожидает"
            ],
            [
                "name" => "В Доставке"
            ],
            [
                "name" => "Доставлен"
            ],
        ]);
    }
}
