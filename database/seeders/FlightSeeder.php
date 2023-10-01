<?php

namespace Database\Seeders;

use App\Models\Flight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 flights
        // 1st flight: 100 seats
        Flight::factory()->create([
            'name' => 'ABC123',
            'origin' => 'LAX',
            'destination' => 'JFK',
            'departure' => '2021-09-30 12:00:00',
            'arrival' => '2021-09-30 18:00:00',
            'seats' => 100,
        ]);
        Flight::factory(10)->create();
    }
}
