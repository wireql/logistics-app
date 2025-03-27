<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\AddressFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AddressCategoriesSeeder::class,
            RoutePointStatusesSeeder::class,
            UserCategoriesSeeder::class,
            VehicleStatusesSeeder::class,
            VehicleCategoriesSeeder::class,
            BodyTypesSeeder::class,
            RouteListStatusesSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            AddressSeeder::class,
            VehicleSeeder::class
        ]);
    }
}
