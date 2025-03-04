<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'name',
        'address_category_id',
        'company_id'
    ];

    public function category() {
        return $this->belongsTo(AddressCategories::class, 'address_category_id');
    }
}