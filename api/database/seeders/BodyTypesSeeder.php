<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BodyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('body_types')->insert([
            [
                "name" => "Тентованный (Тент)"
            ],
            [
                "name" => "Цельнометаллический"
            ],
            [
                "name" => "Бортовой"
            ],
            [
                "name" => "Рефрижератор"
            ],
            [
                "name" => "Цистерна"
            ],
            [
                "name" => "Самосвальный"
            ],
            [
                "name" => "Автовозный"
            ],
            [
                "name" => "Платформа"
            ],
            [
                "name" => "Контейнеровоз"
            ],
        ]);
    }
}
