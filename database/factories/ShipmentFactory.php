<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tracking_number' => Str::random(10),
            'status' => $this->faker->sentence(),
            'weight' => $this->faker->word(),
            'origin' => $this->faker->city(),
            'destination' => $this->faker->city(),
        ];
    }
}
