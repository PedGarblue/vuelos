<?php

namespace Tests\Feature;

use App\Models\Flight;
use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_stores_a_reservation_and_returns_tickets(): void
    {
        $flight = Flight::factory()->create();
        $payload = [
            'flight_id' => $flight->id,
            'seats' => 3,
        ];

        $response = $this->post('/reservations', $payload);

        $response->assertRedirect('/flights');
        $this->assertDatabaseHas('reservations', [
            'flight_id' => $flight->id,
        ]);
        // check that the tickets were created
        $tickets = Ticket::where('reservation_id', 1);  
        $this->assertEquals(3, $tickets->count());
    }

    public function test_returns_errors_when_storing_a_reservation_with_invalid_data(): void
    {
        $flight = Flight::factory()->create();

        $payload = [
            'flight_id' => $flight->id,
            'seats' => 0,
        ];

        $response = $this->post('/reservations', $payload);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['seats']);
    }
    
    public function test_can_view_a_reservation(): void {
        $reservation = Reservation::factory()->create();
        $tickets = Ticket::factory()->count(3)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->get('/reservations/' . $reservation->id);

        $response->assertOk();
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Reservation/Show')
            ->has('reservation', fn (Assert $page) => $page
                ->where('id', $reservation->id)
                ->where('flight_id', $reservation->flight_id)
                ->has('flight', fn (Assert $page) => $page
                    ->where('id', $reservation->flight->id)
                    ->where('name', $reservation->flight->name)
                    ->where('origin', $reservation->flight->origin)
                    ->where('destination', $reservation->flight->destination)
                    ->where('departure', $reservation->flight->departure->format('Y-m-d H:i'))
                    ->where('arrival', $reservation->flight->arrival->format('Y-m-d H:i'))
                    ->where('seats', $reservation->flight->seats)
                    ->where('available_seats', $reservation->flight->seats - 3)
                )
                ->has('tickets', 3, fn ($json) => $json
                    ->where('id', $tickets[0]->id)
                    ->where('reservation_id', $reservation->id)
                )
                ->has('created_at')
                ->has('updated_at')
            )
        );
    }

    public function test_can_update_a_reservation_and_remove_seats(): void {
        $flight = Flight::factory()->create();
        $reservation = Reservation::factory()->create([
            'flight_id' => $flight->id,
        ]);
        Ticket::factory()->count(3)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->put('/reservations/' . $reservation->id, [
            'seats' => 2,
        ]); 

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $tickets = Ticket::where('reservation_id', $reservation->id)->get();
        $this->assertEquals($tickets->count(), 2);
    }

    public function test_can_update_a_reservation_and_add_seats(): void {
        $flight = Flight::factory()->create();
        $reservation = Reservation::factory()->create([
            'flight_id' => $flight->id,
        ]);
        Ticket::factory()->count(3)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->put('/reservations/' . $reservation->id, [
            'seats' => 4,
        ]); 

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $tickets = Ticket::where('reservation_id', $reservation->id)->get();
        $this->assertEquals($tickets->count(), 4);
    }

    public function test_returns_errors_when_updating_a_reservation_with_invalid_data(): void {
        $flight = Flight::factory()->create();
        $reservation = Reservation::factory()->create([
            'flight_id' => $flight->id,
        ]);
        Ticket::factory()->count(3)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->put('/reservations/' . $reservation->id, [
            'seats' => 0,
        ]); 

        $response->assertRedirect();
        $response->assertSessionHasErrors(['seats']);
    }

    public function test_can_delete_a_reservation(): void {
        $reservation = Reservation::factory()->create();
        $tickets = Ticket::factory()->count(3)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->delete('/reservations/' . $reservation->id);

        $response->assertRedirect('/flights');
        $this->assertNull(Reservation::find($reservation->id));
        // check that the tickets were deleted
        $tickets = Ticket::where('reservation_id', $reservation->id)->count();
        $this->assertEquals(0, $tickets);
    }
}
