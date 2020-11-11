<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderEvent;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return Product::orderBy('id', 'DESC')->get();

    }
    /**
     * Display a listing of the orders.
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function getOrders(User $user)
    {

        return Order::orderBy('created_at', 'DESC')->get();

    }

    public function getOrdersProducts($order)
    {
        // return OrderProduct::orderBy('created_at', 'DESC')->get();

        return Product::join("order_products","products.id","order_products.product_id")
            ->where('order_id',$order)
            ->orderBy('order_products.created_at','desc')
            ->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Todo: Validation
        \DB::beginTransaction();
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->save();
        foreach ($request->cart as $item) {
            \DB::table('order_products')
               ->insert([
                   'order_id' => $order->id,
                   'product_id' => $item['product']['id'],
                   'quantity' => $item['quantity'],
                  // 'price' => $item['price'],
                   'created_at' => now(),
                   'updated_at' => now(),
               ]);
        }
        \DB::commit();

        broadcast(new OrderEvent($order));
          //event(new OrderEvent($order));
        return Order::orderBy('id', 'DESC')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
