<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    protected $table = 'townships';
    protected $fillable = ['name', 'deliveryprice', 'deliveryman']; 

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
