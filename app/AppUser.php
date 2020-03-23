<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    protected $table = 'app_users';
    protected $fillable = [
        'name', 'phone', 'address'
    ];
}
