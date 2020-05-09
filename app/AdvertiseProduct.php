<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiseProduct extends Model
{
    protected $table = 'advertise_products';
    protected $fillable = ['name', 'category_id','code', 'quantity', 'price', 'count_method', 'photo', 'youtube', 'images', 'description'];

    public function photos()
    {
        return $this->hasMany('App\AdvertiseProductPhoto', 'product_id');
    }
}
