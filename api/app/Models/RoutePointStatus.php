<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutePointStatus extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
    ];
}
