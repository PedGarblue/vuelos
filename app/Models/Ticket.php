<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;

class Ticket extends Model
{
    use HasFactory;

    protected $fields = [
        'reservation_id',
    ];

    protected $fillable = [
        'reservation_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function reservation() {
        return $this->belongsTo(Reservation::class);
    }
}
