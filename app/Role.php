<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = role;
    protected $fillable = ['name'];
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
