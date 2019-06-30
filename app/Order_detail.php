<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    protected $table = 'order_details';
    protected $fillable = ['name', 'quantity', 'price','totalprice', 'user_id', 'product_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
