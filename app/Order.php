<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['totalquantity', 'totalprice','orderdate','monthly','yearly', 'deliverystatus', 'user_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function orderdetails()
    {
        return $this->hasMany('App\Order_detail');
    }
}
