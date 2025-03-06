<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPoint extends Model
{
    protected $fillable = [
        'address_from_id',
        'address_to_id',
        'plan_delivery',
        'task_id',
        'task_point_status_id',
    ];

    public function task() {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
