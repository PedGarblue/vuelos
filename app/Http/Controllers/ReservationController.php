<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
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
        $previous_route = url()->previous();
        return Inertia::render('Reservation/Create', [
            'flight' => $flight,
            'return_route' => $previous_route,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request): RedirectResponse
    {
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
    public function update(UpdateReservationRequest $request, Reservation $reservation): RedirectResponse
    {
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
