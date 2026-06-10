<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('products');
        Storage::disk('public')->deleteDirectory('categories');

        //Generate child models when creating a parent model no need seeders file category/product
        Category::factory(5)
            ->has(Product::factory()->count(10))
            ->create();
    }
}
