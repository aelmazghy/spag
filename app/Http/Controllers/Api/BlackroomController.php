<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\Status;
use Illuminate\Http\Request;

class BlackroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getAllOrders()
    {

        // return Order::orderBy('created_at', 'DESC')->get(); auth()->user(); // user
        return Order::selectraw("orders.* , sum(order_products.quantity * products.vSal_Base) as total")
            ->join("order_products","orders.id","order_products.order_id")
            ->join("products","products.id","order_products.product_id")
            ->orderBy('created_at', 'DESC')
            ->groupby("orders.id","orders.user_id","orders.status_id","created_at","updated_at")
            ->get();

    }
    public function getAllStatus()
    {
        return Status::orderBy('created_at', 'DESC')->get();
    }
    public function getOrdersProducts($order)
    {
       // return OrderProduct::orderBy('created_at', 'DESC')->get();

        return \App\Product::join("order_products","products.id","order_products.product_id")
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
        //
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
