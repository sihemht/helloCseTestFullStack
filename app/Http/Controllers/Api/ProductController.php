<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ApiResponseServices;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function __construct(
        private readonly ApiResponseServices $apiResponseServices,
        private readonly ProductService $productService
    ){}


    /**
     * Display a listing of the product or filter product of category.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if($request->has('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }
        $products = $query->get();

        return $this->apiResponseServices->success(
            ProductResource::collection($products),
            "Products list retrieved successfully"
        );
    }

    //New product
    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        return $this->apiResponseServices->success(
            new ProductResource($product),
            "Product created successfully",
            201
        ); }

    //Product $product equivalent findOrFail
    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return $this->apiResponseServices->success($product, 'Product find successfully');
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $productUpdated = $this->productService->updateProduct($product, $request->validated());
        return $this->apiResponseServices->success(new ProductResource($productUpdated), 'Product updated successfully');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        return $this->apiResponseServices->success(null, 'Product deleted successfully');
    }
}
