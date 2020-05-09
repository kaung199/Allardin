<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiseProductPhoto extends Model
{
    protected $table = 'advertise_product_photos';
    protected $fillable = ['product_id', 'filename'];
}
