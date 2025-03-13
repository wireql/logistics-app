<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteListStatus extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
    ];
}
