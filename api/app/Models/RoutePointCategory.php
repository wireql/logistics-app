<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutePointCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
