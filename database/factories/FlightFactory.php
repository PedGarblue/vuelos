<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->regexify('[A-Z]{3}[0-9]{3}'),
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'departure' => $this->faker->dateTime,
            'arrival' => $this->faker->dateTime,
            'seats' => $this->faker->numberBetween(100, 200),
        ];
    }
}
