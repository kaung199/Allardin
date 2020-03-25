<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'session';
    protected $fillable = ['product_id', 'user_id','name', 'quantity','price', 'total_price'];

    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id')->select('id', 'name', 'price');
    }
    public function productPhoto()
    {
        return $this->belongsTo('App\ProductsPhoto', 'product_id')->select('id', 'filename');
    }
}
