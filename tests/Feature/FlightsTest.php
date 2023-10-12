<?php

namespace Tests\Feature;

use App\Models\Flight;
use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class FlightsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_renders_flight_reservation_page(): void
    {
        $flight = Flight::factory()->create();

        $response = $this->get('/flights/' . $flight->id . '/reserve');

        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($flight) {
                $page->component('Reservation/Create')
                    ->has('flight', fn (Assert $page) => $page
                        ->where('id', $flight->id)
                        ->where('name', $flight->name)
                        ->where('origin', $flight->origin)
                        ->where('destination', $flight->destination)
                        ->where('departure', $flight->departure->format('Y-m-d H:i'))
                        ->where('arrival', $flight->arrival->format('Y-m-d H:i'))
                        ->where('seats', $flight->seats)
                        ->where('available_seats', $flight->seats)
                    );
            });
    }

    public function test_lists_flights_and_renders_correctly(): void
    {
        $flights = Flight::factory(20)->create();
        $first_flight = Flight::factory()->create([
            // always be the first because of the sorting
            'seats' => 1,
        ]);
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
            ->assertInertia(function (Assert $page) use ($first_flight) {
                $page->component('Flight/Index')
                    ->has('flights', 21, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'name',
                            'origin',
                            'destination',
                            'departure',
                            'arrival',
                            'seats',
                            'available_seats',
                        ]);
                    })
                    ->where('flights.0.id', $first_flight->id)
                    ->where('flights.0.name', $first_flight->name)
                    ->where('flights.0.origin', $first_flight->origin)
                    ->where('flights.0.destination', $first_flight->destination)
                    // cast to string to compare the date format (Y-m-d H:i)
                    ->where('flights.0.departure', $first_flight->departure->format('Y-m-d H:i'))
                    ->where('flights.0.arrival', $first_flight->arrival->format('Y-m-d H:i'))
                    ->where('flights.0.seats', $first_flight->seats)
                    ->where('flights.0.available_seats', $first_flight->seats) // This is a computed property, so it's not in the database
                    ->has('reservations', 1, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'flight_id',
                            'flight',
                            'tickets',
                            'created_at',
                            'updated_at',
                        ]);
                    });
            });
    }

    public function test_list_flights_renders_correctly_and_omits_full_flights() {
        Flight::factory(20)->create();
        $full_flight = Flight::factory()->create([
            'seats' => 10,
        ]);
        $reservation = Reservation::factory()->create([
            'flight_id' => $full_flight->id,
        ]);
        Ticket::factory(10)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->get('/flights');

        $response->assertOk()
            ->assertInertia(function (Assert $page) use ($full_flight) {
                $page->component('Flight/Index')
                    ->has('flights', 20, function (Assert $flight) {
                        $flight->hasAll([
                            'id',
                            'name',
                            'origin',
                            'destination',
                            'departure',
                            'arrival',
                            'seats',
                            'available_seats',
                        ]);
                        $flight->whereNot('available_seats', 0);
                    });
            });

    }

    public function test_list_can_perform_flight_search_term_by_origin(): void
    {
        Flight::factory(20)->create();

        $flight_to_search = Flight::factory()->create([
            'origin' => 'LAX',
            'destination' => 'JFK',
        ]);

        $response = $this->get('/flights?origin='. $flight_to_search->origin);
        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($flight_to_search) {
                $page->component('Flight/Index')
                    ->has('flights', 1, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'name',
                            'origin',
                            'destination',
                            'departure',
                            'arrival',
                            'seats',
                            'available_seats',
                        ]);
                    })
                    ->where('flights.0.id', $flight_to_search->id)
                    ->where('flights.0.name', $flight_to_search->name)
                    ->where('flights.0.origin', $flight_to_search->origin)
                    ->where('flights.0.destination', $flight_to_search->destination)
                    // cast to string to compare the date format (Y-m-d H:i)
                    ->where('flights.0.departure', $flight_to_search->departure->format('Y-m-d H:i'))
                    ->where('flights.0.arrival', $flight_to_search->arrival->format('Y-m-d H:i'))
                    ->where('flights.0.seats', $flight_to_search->seats)
                    ->where('flights.0.available_seats', $flight_to_search->seats)
                    ->has('reservations', 0)
                    ->has('search', function (Assert $page) use ($flight_to_search) {
                        $page->where('origin', $flight_to_search->origin);
                        $page->where('destination', null);
                        $page->where('from', null);
                        $page->where('to', null);
                    });
            });
    } 

    public function test_list_can_perform_flight_search_term_by_destination(): void
    {
        Flight::factory(20)->create();

        $flight_to_search = Flight::factory()->create([
            'origin' => '',
            'destination' => 'JFK',
        ]);

        $response = $this->get('/flights?destination='. $flight_to_search->destination);
        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($flight_to_search) {
                $page->component('Flight/Index')
                    ->has('flights', 1, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'name',
                            'origin',
                            'destination',
                            'departure',
                            'arrival',
                            'seats',
                            'available_seats',
                        ]);
                    })
                    ->where('flights.0.id', $flight_to_search->id)
                    ->where('flights.0.name', $flight_to_search->name)
                    ->where('flights.0.origin', $flight_to_search->origin)
                    ->where('flights.0.destination', $flight_to_search->destination)
                    // cast to string to compare the date format (Y-m-d H:i)
                    ->where('flights.0.departure', $flight_to_search->departure->format('Y-m-d H:i'))
                    ->where('flights.0.arrival', $flight_to_search->arrival->format('Y-m-d H:i'))
                    ->where('flights.0.seats', $flight_to_search->seats)
                    ->where('flights.0.available_seats', $flight_to_search->seats)
                    ->has('reservations', 0)
                    ->has('search', function (Assert $page) use ($flight_to_search) {
                        $page->where('origin', null);
                        $page->where('destination', $flight_to_search->destination);
                        $page->where('from', null);
                        $page->where('to', null);
                    });

            });
    } 

    public function test_list_can_perform_flight_sorting_by_seats_ascending(): void {

        $flight_taken = Flight::factory()->create([
            'origin' => '',
            'destination' => 'JFK',
        ]);
        $reservation = Reservation::factory()->create([
            'flight_id' => $flight_taken->id,
        ]);
        Ticket::factory(10)->create([
            'reservation_id' => $reservation->id,
        ]);

        // flight with no seats taken
        $flight = Flight::factory()->create();

        $response = $this->get('/flights');
        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($flight_taken, $flight) {
                $page->component('Flight/Index')
                    ->has('flights', 2, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'name',
                            'origin',
                            'destination',
                            'departure',
                            'arrival',
                            'seats',
                            'available_seats',
                        ]);
                    })
                    ->where('flights.0.id', $flight_taken->id);
            });
    }

    public function test_list_can_perform_flight_search_by_min_date(): void
    {
        Flight::factory(20)->create([
            'departure' => $this->faker->dateTimeBetween('1 day', '15 days')
        ]);

        $flight_to_search = Flight::factory()->create([
            'departure' => now()->addMonth(1),
        ]);

        $response = $this->get('/flights?from='. $flight_to_search->departure->format('Y-m-d H:i'));
        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($flight_to_search) {
                $page->component('Flight/Index')
                    ->has('flights', 1, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'name',
                            'origin',
                            'destination',
                            'departure',
                            'arrival',
                            'seats',
                            'available_seats',
                        ]);
                    })
                    ->where('flights.0.id', $flight_to_search->id)
                    ->where('flights.0.name', $flight_to_search->name)
                    ->where('flights.0.origin', $flight_to_search->origin)
                    ->where('flights.0.destination', $flight_to_search->destination)
                    // cast to string to compare the date format (Y-m-d H:i)
                    ->where('flights.0.departure', $flight_to_search->departure->format('Y-m-d H:i'))
                    ->where('flights.0.arrival', $flight_to_search->arrival->format('Y-m-d H:i'))
                    ->where('flights.0.seats', $flight_to_search->seats)
                    ->where('flights.0.available_seats', $flight_to_search->seats)
                    ->has('reservations', 0)
                    ->has('search', function (Assert $page) use ($flight_to_search) {
                        $page->where('origin', null);
                        $page->where('destination', null);
                        $page->where('from', $flight_to_search->departure->format('Y-m-d H:i'));
                        $page->where('to', null);
                    });

            });
    } 

    public function test_list_can_perform_flight_search_by_max_date(): void
    {
        Flight::factory(20)->create([
            'departure' => $this->faker->dateTimeBetween('2 months', '3 months'),
        ]);

        $flight_to_search = Flight::factory()->create([
            'departure' => now()->addMonth(1),
        ]);

        $response = $this->get('/flights?to='. $flight_to_search->departure->format('Y-m-d H:i:s'));
        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($flight_to_search) {
                $page->component('Flight/Index')
                    ->has('flights', 1, function (Assert $page) {
                        $page->hasAll([
                            'id',
                            'name',
                            'origin',
                            'destination',
                            'departure',
                            'arrival',
                            'seats',
                            'available_seats',
                        ]);
                    })
                    ->where('flights.0.id', $flight_to_search->id)
                    ->where('flights.0.name', $flight_to_search->name)
                    ->where('flights.0.origin', $flight_to_search->origin)
                    ->where('flights.0.destination', $flight_to_search->destination)
                    // cast to string to compare the date format (Y-m-d H:i)
                    ->where('flights.0.departure', $flight_to_search->departure->format('Y-m-d H:i'))
                    ->where('flights.0.arrival', $flight_to_search->arrival->format('Y-m-d H:i'))
                    ->where('flights.0.seats', $flight_to_search->seats)
                    ->where('flights.0.available_seats', $flight_to_search->seats)
                    ->has('reservations', 0)
                    ->has('search', function (Assert $page) use ($flight_to_search) {
                        $page->where('origin', null);
                        $page->where('destination', null);
                        $page->where('from', null);
                        $page->where('to', $flight_to_search->departure->format('Y-m-d H:i:s'));
                    });

            });
    } 
}