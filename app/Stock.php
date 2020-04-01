<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = "stock_check";
    protected $fillable = [
        'product_id',
        'qty',
        'r_qty',
        'date',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
