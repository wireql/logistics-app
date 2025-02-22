<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPoint extends Model
{
    protected $fillable = [
        'address_from_id',
        'address_to_id',
        'cargo_id',
        'delivery',
        'task_id',
        'task_point_status_id',
    ];
}
