<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //image file
        $fakeImage = UploadedFile::fake()->image('image_product.jpg', 150, 150);

        //store in storage/app/public/products
        $imagePath = Storage::disk('public')->putfile('products', $fakeImage);

        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'image' => $imagePath,
            'status' => $this->faker->randomElement([ProductStatus::ONLINE, ProductStatus::DRAFT, ProductStatus::ARCHIVED]),
            'category_id' => Category::factory(),
        ];
    }
}
