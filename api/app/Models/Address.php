<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'region',
        'city',
        'street',
        'building',
        'flat',
        'latitude',
        'longitude',
        'address_category_id',
        'company_id'
    ];

    public function category()
    {
        return $this->belongsTo(AddressCategories::class, 'address_category_id');
    }
}
