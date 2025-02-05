<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrailerType extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
    ];
}
