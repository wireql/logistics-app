<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trailer extends Model
{
    protected $fillable = [
        'register_number',
        'user_id',
        'body_type_id',
        'trailer_type_id',
    ];
}
