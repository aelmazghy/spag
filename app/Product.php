<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'vSal_Base', 'image'
    ];

    public function spot()
    {
        return $this->belongsTo('App\Spot');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'orders_id')
            ->withTimestamps();
    }
    public function OrderProduct()
    {
        return $this->belongsToMany('App\OrderProduct');
    }
}
