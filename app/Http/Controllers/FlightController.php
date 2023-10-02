<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexFlightRequest;
use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexFlightRequest $request): Response
    {
        // search if it exists
        $flights = Flight::query()
            ->when($request->origin, function ($query, $search) {
                $query->orWhere('origin', 'like', "%{$search}%");
            })
            ->when($request->destination, function ($query, $search) {
                $query->orWhere('destination', 'like', "%{$search}%");
            })
            ->get();
        $reservations = Reservation::all();
        $reservations->load(['tickets', 'flight']);

        return Inertia::render('Flight/Index', [
            'flights' => $flights,
            'reservations' => $reservations,
            'search' => $request->all(['origin', 'destination']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        //
    }
}
