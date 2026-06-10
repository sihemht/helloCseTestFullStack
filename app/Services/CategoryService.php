<?php
namespace App\Services;


use App\Models\Category;
use Illuminate\Http\UploadedFile;

readonly class CategoryService {

    public function __construct(private ImageService $imageService)
    {

    }
    public function createCategory(array$data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->imageService->upload($data['image'], 'categories');
        }
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($category->image) {
                $this->imageService->delete($category->image);
            }
            $data['image'] = $this->imageService->upload($data['image'], 'categories');
        }

        $category->update($data);
        return $category;
    }

    public function deleteCategory(Category $category): void{

        if($category->image){
            $this->imageService->delete($category->image);
        }
        $category->delete();
    }

}
