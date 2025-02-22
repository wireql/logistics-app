<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('address_categories')->insert([
            [
                "name" => "Клиент"
            ],
            [
                "name" => "Склад"
            ],
            [
                "name" => "Магазин"
            ],
        ]);
    }
}
