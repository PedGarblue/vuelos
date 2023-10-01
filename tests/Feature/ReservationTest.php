<?php

namespace Tests\Feature;

use App\Models\Flight;
use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Creates a reservation with a flight id and number of seats
     * Should generate tickets for each seat
     */
    public function test_can_create_a_reservation_and_returns_tickets(): void
    {
        $flight = Flight::factory()->create();
        $payload = [
            'flight_id' => $flight->id,
            'seats' => 3,
        ];

        $response = $this->post('/reservations', $payload);

        $response->assertCreated();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->where('id', 1)
            ->where('flight_id', $flight->id)
            ->has('tickets', 3, fn ($json) => $json
                ->where('id', 1)
                ->where('reservation_id', 1)
            )
            ->has('created_at')
            ->has('updated_at')
        );
        // check that the tickets were created
        $tickets = Ticket::where('reservation_id', 1);  
        $this->assertEquals(3, $tickets->count());
    }

    
    public function test_can_view_a_reservation(): void {
        $reservation = Reservation::factory()->create();
        $tickets = Ticket::factory()->count(3)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->get('/reservations/' . $reservation->id);

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->where('id', $reservation->id)
            ->where('flight_id', $reservation->flight_id)
            ->has('tickets', 3, fn ($json) => $json
                ->where('id', $tickets[0]->id)
                ->where('reservation_id', $reservation->id)
            )
            ->has('created_at')
            ->has('updated_at')
        );
    }

    public function test_can_update_a_reservation(): void {
        $flight = Flight::factory()->create();
        $reservation = Reservation::factory()->create();
        Ticket::factory()->count(3)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->put('/reservations/' . $reservation->id, [
            'flight_id' => $flight->id,
            'seats' => 2,
        ]); 

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => 
            $json->where('id', $reservation->id)
                ->where('flight_id', $flight->id)
                ->has('tickets', 2)
                ->has('created_at')
                ->has('updated_at')

        );
    }

    public function test_can_delete_a_reservation(): void {
        $reservation = Reservation::factory()->create();
        $tickets = Ticket::factory()->count(3)->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->delete('/reservations/' . $reservation->id);

        $response->assertNoContent();
        // check that the tickets were deleted
        $tickets = Ticket::where('reservation_id', $reservation->id)->count();
        $this->assertEquals(0, $tickets);
    }
}
