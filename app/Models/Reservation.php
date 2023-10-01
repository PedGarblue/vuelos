<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Flight;

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
}
