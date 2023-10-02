<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fields = [
        'name',
        'origin',
        'destination',
        'departure',
        'arrival',
        'seats',
    ];

    protected $fillable = [
        'name',
        'origin',
        'destination',
        'departure',
        'arrival',
        'seats',
    ];

    protected $casts = [
        'departure' => 'datetime:Y-m-d H:i',
        'arrival' => 'datetime:Y-m-d H:i',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'reservations',
    ];

    protected $appends = [
        'available_seats',
    ];

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function getAvailableSeatsAttribute() {
        $sum = $this->reservations->sum(function ($reservation) {
            return $reservation->tickets->count();
        });
        return $this->seats - $sum;
    }
}
