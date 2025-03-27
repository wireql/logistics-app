<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country' => $this->faker->country,
            'region' => $this->faker->state,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'building' => $this->faker->buildingNumber,
            'flat' => $this->faker->optional()->randomDigitNotNull,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'address_category_id' => 1,
            'company_id' => 1,
        ];
    }
}
