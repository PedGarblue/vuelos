<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Flight;
use App\Models\Ticket;

class Reservation extends Model
{
    use HasFactory;

    protected $fields = [
        'flight_id',
    ];

    protected $fillable = [
        'flight_id',
    ];

    public function flight() {
        return $this->belongsTo(Flight::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function updateSeats(int $seats) {
        // when updating a reservation, we need to make sure that the number of tickets
        // matches the number of seats
        // if a reservation has 3 tickets and we update it to have 5 seats, we need to create 2 more tickets
        // if a reservation has 3 tickets and we update it to have 2 seats, we need to delete 1 ticket
        $tickets = $this->tickets;
        if ($tickets->count() < $seats) {
            $tickets->createMany(
                array_fill(0, $seats - $tickets->count(), [])
            );
        } else if ($tickets->count() > $seats) {
            $tickets->sortByDesc('id')->take($tickets->count() - $seats)->each->delete();
        }
        
    }
}
