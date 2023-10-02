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
        $departure = $this->faker->dateTimeBetween('now', '+ 1 year');
        $arrival = $this->faker->dateTimeBetween($departure, $departure->format('Y-m-d H:i:s') . ' + 6 hours');
        return [
            'name' => $this->faker->regexify('[A-Z]{3}[0-9]{3}'),
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'departure' => $departure,
            'arrival' => $arrival,
            'seats' => $this->faker->numberBetween(100, 200),
        ];
    }
}
