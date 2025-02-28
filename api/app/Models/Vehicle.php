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

    public function status() {
        return $this->belongsTo(VehicleStatus::class, 'vehicle_status_id');
    }

    public function category() {
        return $this->belongsTo(VehicleCategorie::class, 'vehicle_category_id');
    }

    public function body_type() {
        return $this->belongsTo(BodyType::class, 'body_type_id');
    }
}
