<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FlightController;

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

Route::get('/dashboard', ['DasboardController@index', 'as' => 'dasboard.index']);
