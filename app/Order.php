<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Order extends Model implements Searchable
{
    protected $table = 'orders';
    protected $fillable = [
        'order_id','delivery_id',
        'totalquantity',
        'discount',
        'deliverydate',
        'orderby',
        'remark', 
        'totalprice',
        'grandtotal',
        'orderdate',
        'monthly',
        'yearly', 
        'deliverystatus', 
        'checkstatus',
        'dname','dphone', 
        'user_id'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function delivery()
    {
    	return $this->belongsTo('App\Delivery');
    }

    public function orderdetails()
    {
        return $this->hasMany('App\Order_detail');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('orderdetail', $this->id);

        return new SearchResult(
            $this,
            'Customer = ' . $this->user->name . ', Order_id = ' .  $this->order_id,
            $url
         );
    }
}
