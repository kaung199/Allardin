<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sale_details';
    protected $fillable = [
        'sale_id',
        'product_id',
        'code',
        'qty',
        'total_price'
    ];
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function sale()
    {
        return $this->belongsTo('App\Sale');
    }
}
