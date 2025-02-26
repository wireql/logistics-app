<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_statuses')->insert([
            [
                "name" => "Активный"
            ],
            [
                "name" => "В рейсе"
            ],
            [
                "name" => "Ожидание загрузки"
            ],
            [
                "name" => "Ожидание разгрузки"
            ],
            [
                "name" => "На обслуживании"
            ],
            [
                "name" => "Заблокирован"
            ],
        ]);
    }
}
