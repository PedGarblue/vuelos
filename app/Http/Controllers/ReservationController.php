<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Reservation
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'seats' => 'required|integer|min:1',
        ]);
        $reservation = Reservation::create($request->all());
        $reservation->tickets()->createMany(
            array_fill(0, $request->seats, [])
        );
        $reservation->load('tickets');

        return $reservation;
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load('tickets');
        return $reservation;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'seats' => 'required|integer|min:1',
        ]);

        $reservation->update($request->all());
        $reservation->updateSeats($request->seats);

        $reservation->load('tickets');

        return $reservation;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->noContent();
    }
}
