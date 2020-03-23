<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'session';
    protected $fillable = ['product_id', 'user_id','name', 'quantity','price', 'total_price']; 
}
