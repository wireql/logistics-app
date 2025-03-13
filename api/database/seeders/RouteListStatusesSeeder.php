<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteListStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('route_list_statuses')->insert([
            [
                "name" => "Новая"
            ],
            [
                "name" => "Активная"
            ],
            [
                "name" => "Архивная"
            ],
        ]);
    }
}
