<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RouteList extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'plan_delivery',
        'description',
        'vehicle_id',
        'user_id',
        'company_id',
        'route_list_status_id',
        'ended_at',
    ];

    protected static function boot() {
        parent::boot();
        
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function route_points() {
        return $this->hasMany(RoutePoint::class, 'route_list_id', 'id');
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function driver() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status() {
        return $this->belongsTo(RouteListStatus::class, 'route_list_status_id', 'id');
    }
}
