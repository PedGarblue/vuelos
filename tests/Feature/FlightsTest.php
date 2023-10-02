<?php

namespace Tests\Feature;

use App\Models\Flight;
use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class FlightsTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_flights_and_renders_correctly(): void
    {
        $flights = Flight::factory(20)->create();
        $reservation = Reservation::factory()->create([
            'flight_id' => $flights->first()->id,
        ]);
        Ticket::factory()
            ->count(3)
            ->create([
                'reservation_id' => $reservation->id,
            ]);

        $response = $this->get('/flights');
        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($flights) {
                $page->component('Flight/Index')
                    ->has('flights', 20, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'name',
                            'origin',
                            'destination',
                            'departure',
                            'arrival',
                            'seats',
                            'available_seats',
                            'reservations',
                        ]);
                    })
                    ->where('flights.0.id', 1)
                    ->where('flights.0.name', $flights->first()->name)
                    ->where('flights.0.origin', $flights->first()->origin)
                    ->where('flights.0.destination', $flights->first()->destination)
                    // cast to string to compare the date format (Y-m-d H:i)
                    ->where('flights.0.departure', $flights->first()->departure->format('Y-m-d H:i'))
                    ->where('flights.0.arrival', $flights->first()->arrival->format('Y-m-d H:i'))
                    ->where('flights.0.seats', $flights->first()->seats)
                    ->where('flights.0.available_seats', $flights->first()->seats - 3) // This is a computed property, so it's not in the database
                    ->has('reservations', 1, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'flight_id',
                            'tickets',
                            'created_at',
                            'updated_at',
                        ]);
                    });
            });
    }
}