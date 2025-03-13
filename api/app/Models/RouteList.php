<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteList extends Model
{
    protected $fillable = [
        'plan_delivery',
        'description',
        'vehicle_id',
        'user_id',
        'company_id',
        'route_list_status_id',
        'ended_at',
    ];

    public function route_points() {
        return $this->hasMany(RoutePoint::class, 'route_list_id', 'id');
    }
}
