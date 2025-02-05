<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasUuids;

    protected $fillable = [
        'address_from',
        'address_to',
        'cargo_name',
        'deadline',
        'vehicle_id',
        'user_id',
        'task_status_id',
    ];
}
