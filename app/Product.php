<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'image', 'type'
    ];

    public function getPriceAttribute($value)
    {
        return "$".$value;
    }

}
