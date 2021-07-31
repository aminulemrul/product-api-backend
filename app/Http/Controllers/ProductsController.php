<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function all()
    {
        $products = Products::all();
        return response()->json($products);
    }
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image_name = time().$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $image_name);
        }else{
            $image_name = 'default.jpg';
        }

        $product = new Products;
        $product->image = $image_name;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

//        $product = Products::create($request->all());
        return response()->json(['message'=> 'Product created',
            'product' => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products, $id)
    {
        return Products::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        $products = Products::find($id);
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $image_name = time().$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $image_name);
            $products->image = $image_name;
        }else{
            $products->image = $request->image;
        }
        $products->title = $request->title;
        $products->price = $request->price;
        $products->description = $request->description;
        $products->update();

        return response()->json([
            'message' => 'Product updated!',
            'expense' => $products
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Products::find($id);
        $products->delete();
        return response()->json([
            'message' => 'Product deleted'
        ]);
    }
}
