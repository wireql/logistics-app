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
}
