<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['totalquantity', 'totalprice', 'deliverystatus', 'orderdate', 'user_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
