<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Product;
use App\Services\ApiResponseServices;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        private readonly ApiResponseServices $apiResponseServices,
        private readonly CategoryService $categoryService)
    {

    }

    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::withCount([
            'products' => fn($query) => $query->where('status', ProductStatus::ONLINE)
        ])->get();
        return $this->apiResponseServices
            ->success(CategoryResource::collection($categories), "Category list retrieved successfully");
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());
        return $this->apiResponseServices
            ->success(new CategoryResource($category), "Category created successfully", 201);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $category->loadCount([
            'products' => fn($query) => $query->where('status', ProductStatus::ONLINE)
        ]);
        return $this->apiResponseServices
            ->success(new CategoryResource($category), "Category found successfully");
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $updatedCategory = $this->categoryService->updateCategory($category, $request->validated());
        return $this->apiResponseServices
            ->success(new CategoryResource($updatedCategory), "Category updated successfully");
    }

    /**
     * Remove the specified category and product they attached with
     */
    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);
        return $this->apiResponseServices
            ->success(null, "Category deleted successfully");
    }
}
