<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart_product extends Model
{
    protected $table = 'app_card_products';
    protected $fillable = [
        'product_id', 'name', 'price', 'quantity', 'image', 'cart_id'
    ];

    public function cart() 
    {
        return $this->belongsTo('App\Cart');
    }
}
