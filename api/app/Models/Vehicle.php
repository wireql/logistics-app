<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'vin_number',
        'register_number',
        'milleage',
        'vehicle_status_id',
        'vehicle_categorie_id',
        'user_id',
        'body_type_id',
    ];
}
