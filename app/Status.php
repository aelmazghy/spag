<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name'
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
