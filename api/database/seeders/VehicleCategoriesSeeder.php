<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_categories')->insert([
            [
                "name" => "Фура"
            ],
            [
                "name" => "Фургон"
            ],
            [
                "name" => "Автопоезд"
            ],
            [
                "name" => "Грузовик 3.5т - 12т"
            ],
            [
                "name" => "Спецтехника"
            ],
        ]);
    }
}
