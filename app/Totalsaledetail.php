<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Totalsaledetail extends Model
{
    protected $table = 'totalsaledetail';
    protected $fillable = ['user_id', 'totalqty', 'totalprice', 'date', 'tsp_id'];


    public function totalsaleproduct()
    {
        return $this->belongsTo('App\Totalsaleproduct');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
