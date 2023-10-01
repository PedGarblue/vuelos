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

    protected $casts = [
        'departure' => 'datetime:Y-m-d H:i',
        'arrival' => 'datetime:Y-m-d H:i',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
