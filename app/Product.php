<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'quantity', 'price', 'count_method', 'photo', 'images', 'description'];


    public function photos()
    {
        return $this->hasMany('App\ProductsPhoto');
    }
}
