<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';
    protected $fillable = [
        'user_id', 'product_id'
    ];

    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id')->select('id', 'name', 'price');
    }
    public function productPhoto()
    {
        return $this->belongsTo('App\ProductsPhoto', 'product_id')->select('id', 'filename');
    }
}
