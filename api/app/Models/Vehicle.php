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
        'max_volume',
        'max_weight',
        'vehicle_status_id',
        'vehicle_category_id',
        'body_type_id',
        'company_id',
    ];
}
