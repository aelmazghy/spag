<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    protected $fillable = [
        'name', 'slug'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function products()
    {
        return $this->hasMany('App\Project');
    }
}
