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
        ]);

        return Reservation::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return $reservation;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
        ]);

        $reservation->update($request->all());

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
