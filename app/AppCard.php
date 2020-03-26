<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppCard extends Model
{
    protected $table = 'app_cards';
    protected $fillable = [
        'name','app_user_id', 'phone', 'address', 'township_id','customer_status', 'discount', 'delivery_date', 'remark'
    ];
}
