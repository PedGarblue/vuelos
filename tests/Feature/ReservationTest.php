<?php

namespace Tests\Feature;

use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Creates a reservation with a flight id and number of seats
     * Should generate tickets for each seat
     */
    public function test_can_create_a_reservation(): void
    {
        $flight = Flight::factory()->create();
        $payload = [
            'flight_id' => $flight->id,
        ];

        $response = $this->post('/reservations', $payload);

        $response->assertCreated();
        $response->assertJson([
            'id' => 1,
            'flight_id' => $flight->id,
        ], true);
    }

    
    public function test_can_view_a_reservation(): void {
        $reservation = Reservation::factory()->create();

        $response = $this->get('/reservations/' . $reservation->id);

        $response->assertOk();
        $response->assertJson([
            'id' => $reservation->id,
            'flight_id' => $reservation->flight_id,
        ], true);
    }

    public function test_can_update_a_reservation(): void {
        $flight = Flight::factory()->create();
        $reservation = Reservation::factory()->create();

        $response = $this->put('/reservations/' . $reservation->id, [
            'flight_id' => $flight->id,
        ]); 

        $response->assertOk();
        $response->assertJson([
            'id' => $reservation->id,
            'flight_id' => $flight->id,
        ], true);
    }

    public function test_can_delete_a_reservation(): void {
        $reservation = Reservation::factory()->create();

        $response = $this->delete('/reservations/' . $reservation->id);

        $response->assertNoContent();
    }
}
