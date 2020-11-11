<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [

    ];
    public function spot()
    {
        return $this->belongsTo('App\Spot');
    }
    public function user()
    {
        return $this->hasOne('App\User');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function orderProducts()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'orders_id', 'product_id')
            ->withTimestamps();
    }
}
