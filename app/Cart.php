<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'name','app_user_id', 'phone', 'address', 'township_id','customer_status', 'discount', 'delivery_date', 'remark'
    ];

    public function cart_products()
    {
        return $this->hasMany('App\Cart_product');
    }
    public function township()
    {
        return $this->belongsTo('App\Township');
    }
}
