<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => "Иван",
                'middle_name' => "Иванов",
                'last_name' => "Иванович",
                'company_id' => 1,
                'user_category_id' => 1,
                'email' => "dmtr.off.p@gmail.com",
                'password' => Hash::make('123123'),
            ]
        ]);

        User::factory()->count(10)->create();
    }
}
