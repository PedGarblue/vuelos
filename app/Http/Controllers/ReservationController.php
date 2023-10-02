<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ReservationController extends Controller
{
    public function create(Request $request): Response
    {
        $flight = Flight::findOrFail($request->flight);
        return Inertia::render('Reservation/Create', [
            'flight' => $flight,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
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

        return Redirect::route('flights.index')
            ->with('success', 'Reservation created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation): Response
    {
        $reservation->load(['tickets', 'flight']);
        return Inertia::render('Reservation/Show', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $request->validate([
            'seats' => 'required|integer|min:1',
        ]);

        $reservation->update($request->all());
        $reservation->updateSeats($request->seats);

        $reservation->load('tickets');

        return Redirect::route('reservations.show', $reservation)
            ->with('success', 'Reservation updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        $reservation->delete();

        return Redirect::route('flights.index')
            ->with('success', 'Reservation deleted.');
    }
}
