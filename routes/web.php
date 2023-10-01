<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Home', [
        'flights_url' => route('flights.index'),
    ]);
});

Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');

Route::group(['prefix' => 'reservations'], function () {
    Route::get('/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
    Route::put('/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});
