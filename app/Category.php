<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'code', 'name'
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
