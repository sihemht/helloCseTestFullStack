<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

readonly class ProductService
{
    public function __construct(private ImageService $imageService)
    {
    }

    public function createProduct($data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->imageService->upload($data['image'], 'products');
        }
        return Product::create($data);
    }

    public function updateProduct(Product $product, $data): Product
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            //Delete the old image
            $this->imageService->delete($product->image);

            //Uploade the new image
            $data['image'] = $this->imageService->upload($data['image'], 'products');
        }
        $product->update($data);
        return $product;
    }
    public function deleteProduct(Product $product): void
    {
        $this->imageService->delete($product->image);

        //delete from the database
        $product->delete();
    }
}
