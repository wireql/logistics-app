<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutePoint extends Model
{
    protected $fillable = [
        "address_from_id",
        "address_to_id",
        "plan_delivery",
        "route_list_id",
        "route_point_status_id",
    ];

    public function status() {
        return $this->belongsTo(RoutePointStatus::class, 'route_point_status_id');
    }

    public function addressFrom() {
        return $this->belongsTo(Address::class, 'address_from_id');
    }

    public function addressTo() {
        return $this->belongsTo(Address::class, 'address_to_id');
    }

    public function cargos() {
        return $this->hasMany(Cargo::class, 'route_point_id', 'id');
    }
}
