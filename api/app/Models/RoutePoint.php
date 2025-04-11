<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutePoint extends Model
{
    protected $fillable = [
        "address_id",
        "delivery_date",
        "route_list_id",
        "route_point_status_id",
        "route_point_category_id",
    ];

    public function status()
    {
        return $this->belongsTo(RoutePointStatus::class, 'route_point_status_id');
    }

    public function category()
    {
        return $this->belongsTo(RoutePointCategory::class, 'route_point_category_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function cargos()
    {
        return $this->hasMany(Cargo::class, 'route_point_id', 'id');
    }
}
