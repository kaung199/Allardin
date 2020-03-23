<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppCard extends Model
{
    protected $table = 'app_cards';
    protected $fillable = [
        'name', 'phone', 'address', 'township_id', 'discount', 'delivery_date', 'remark'
    ];
}
