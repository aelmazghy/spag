<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Juste pour info !!
        $start = microtime(true);
        foreach (Product::orderBy('id', 'DESC')->get() as $Product){
            Log::info($Product->name . " // " .  $Product->status->name . " // " .$Product->spot->name);
        }
        $time = microtime(true) - $start;
        Log::info($time);
        $start = microtime(true);
        foreach (Product::orderBy('id', 'DESC')->with('spot','status')->get() as $Product){
            Log::info($Product->name . " // " .  $Product->status->name . " // " .$Product->spot->name);
        }
        $time = microtime(true) - $start;
        Log::info($time);
        */
        return Product::orderBy('id', 'DESC')->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Todo: Validation goes here.

        \DB::beginTransaction();
        $imageFile = $request->file('files')[0];
        $imageName = Str::uuid().'.'.$imageFile->extension();
        $imagePath = public_path().'/products/images/';
        $imageFile->move($imagePath, $imageName);

        $Product = new Product();
        $Product->image = '/products/images/'.$imageName;
        $Product->name = $request->name;
        $Product->description = $request->description;
        $Product->vSal_Base = $request->vSal_Base;

        //   $Product->status_id = 1;
        $Product->save();
        \DB::commit();

          //event(new ChangeProductStatus($Product));
        return Product::orderBy('id', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function openscoring(Request $request, $id)
    {
        $Product = Product::findOrFail($id);
        $Product->status_id = 2;
        $Product->save();

        return Product::orderBy('id', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function closescoring(Request $request, $id)
    {
        $Product = Product::findOrFail($id);
        $Product->status_id = 3;
        $Product->save();

        return Product::orderBy('id', 'DESC')->get();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Product = Product::findOrFail($id);
        $Product->name = $request->name;
        $Product->description = $request->description;
        $Product->vSal_Base = $request->vSal_Base;
        $Product->save();

        return Product::orderBy('id', 'DESC')->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::where('id', $id)->delete();

        return Product::orderBy('id', 'DESC')->get();
    }
}
