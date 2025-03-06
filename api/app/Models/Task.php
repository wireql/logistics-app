<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'plan_delivery',
        'description',
        'vehicle_id',
        'user_id',
        'company_id',
        'task_status_id',
        'ended_at',
    ];

    public function task_points() {
        return $this->hasMany(TaskPoint::class, 'task_id', 'id');
    }
}
