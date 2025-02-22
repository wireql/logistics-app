<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressCategories extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
    ];
}
