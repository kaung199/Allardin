<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Totalsaleproduct extends Model
{
    protected $table = 'totalsaleproducts';
    protected $fillable = ['product_id', 'totalqty','deliveryprice', 'totalprice', 'date'];


    public function totalsaledtails()
    {
        return $this->hasMany('App\Totalsaledetail');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
