<?php

namespace Database\Factories;

use App\Enums\CategoryStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;


/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //image file
        $fakeImage = UploadedFile::fake()->image('image_category.jpg', 150, 150);

        //store in storage/app/public/categories
        //@TODO symbolic link for api
        $imagePath = Storage::disk('public')->putfile('categories', $fakeImage);
        return [
            'name' => $this->faker->word(),
            'image' => $imagePath,
            'status' => $this->faker->randomElement([CategoryStatus::ONLINE, CategoryStatus::DEACTIVATED, CategoryStatus::ARCHIVED]),
        ];
    }
}
