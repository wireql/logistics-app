<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = [
        'name',
        'barcode',
        'description',
        'volume',
        'weight',
        'route_point_id'
    ];
}