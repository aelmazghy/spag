<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    public function order()
    {
        return $this->hasOne('App\Order');
    }
    public function orderProducts()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'orders_id', 'product_id')
            ->withTimestamps();
    }
}
