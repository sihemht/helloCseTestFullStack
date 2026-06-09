<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ApiResponseServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ApiResponseServices $apiResponseServices)
    {

    }
    // List & Filter
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }
        return $this->apiResponseServices->success($query->get(), 'Product list successfully');
    }

    //New product
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData= $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'string|nullable',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($validateData);
        return $this->apiResponseServices->success($product, 'Product created successfully', 201);
    }

    //Product $product do findOrFail
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->apiResponseServices->success($product, 'Product find successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Product $product)
    {
        $validateData= $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'image' => 'string|nullable',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);
        $product->update($validateData);
        return $this->apiResponseServices->success($product, 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->apiResponseServices->success($product, 'Product deleted successfully');
    }
}
