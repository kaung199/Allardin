<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'user_id',
        'qty',
        'date',
        'paid',
        'r_change',
        'invoice_no',
        'total_price'
    ];

    
    public function saleDetail()
    {
        return $this->hasMany('App\SaleDetail');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
