<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		$products = Product::query()
				->name($request->name)
				->minPrice($request->min_price)
				->maxPrice($request->max_price)
				->paginate(
					$request->get('per_page',10)
				);
		
        //
		return response()->json($products,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
        $product = Product::create($request->validated());
		
        return response()->json($product,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
		$product = Product::find($id);

        if(!$product){
            return response()->json([
                'message'=>'Producto no encontrado'
            ],404);
        }

        return response()->json($product,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        //
		$product = Product::find($id);

        if(!$product){
            return response()->json(['message'=>'Producto no encontrado'],404);
        }
        
        $product->update($request->validated());

        return response()->json($product,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
		$product = Product::find($id);

        if(!$product){
            return response()->json(['message'=>'Producto no encontrado'],404);
        }

        $product->delete();

        return response()->json([
            'message'=>'Producto eliminado'
        ],200);
    }
}
