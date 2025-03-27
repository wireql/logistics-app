<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'year' => $this->faker->numberBetween(2000, 2024),
            'vin_number' => strtoupper($this->faker->bothify('???#####???#####')),
            'register_number' => strtoupper($this->faker->bothify('??-###-??')),
            'max_volume' => $this->faker->randomFloat(2, 5, 50),
            'max_weight' => $this->faker->randomFloat(2, 500, 30000),
            'vehicle_status_id' => $this->faker->numberBetween(1, 6),
            'vehicle_category_id' => $this->faker->numberBetween(1, 5),
            'body_type_id' => $this->faker->numberBetween(1, 9),
            'company_id' => 1,
        ];
    }
}
