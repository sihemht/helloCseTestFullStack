<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiResponseServices;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private readonly ApiResponseServices $apiResponseServices)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $this->apiResponseServices->success($categories, "Category list retrieved successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
        ]);
        $category = Category::create($validateData);
        return $this->apiResponseServices->success($category, "Category created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        /** to see category and these products
         * return $this->apiResponseServices->success($category->load("products"), "Category and these products found successfully");
         */
        return $this->apiResponseServices->success($category, "Category found successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validateData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'image' => 'nullable|string|max:255',
            'status' => 'sometimes|string|in:online,deactivated,archived',
        ]);
        $category->update($validateData);
        return $this->apiResponseServices->success($category, "Category updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //delete category and product they attached with
        $category->delete();
        return $this->apiResponseServices->success($category, "Category deleted successfully");
    }
}
