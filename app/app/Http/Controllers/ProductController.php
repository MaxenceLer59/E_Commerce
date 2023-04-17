<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            "status" => 200,
            "data" => Product::all()
        ];
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
            "name" => "required|max:255",
            "description" => "required_without:photo",
            "photo" => "required_without:description",
            "price" => "required|numeric|max:10e6",
        ]);

        $product = Product::create($request->all());

        return [
            "status" => 200,
            "data" => $product,
            "message" => 'Product created successfully', 
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return [
            "status" => 200,
            "data" => $product,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "name" => "required|max:255",
            "description" => "required_without:photo",
            "photo" => "required_without:description",
            "price" => "required|numeric|max:8",
        ]);

        $product->update($request->all());
 
        return [
            "status" => 200,
            "data" => $product,
            "message" => "Product updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return [
            "status" => 200,
            "data" => $product,
            "message" => "Product deleted successfully"
        ];
    }
}
