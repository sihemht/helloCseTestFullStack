<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_products()
    {
        //Create Category
        $category = Category::factory()->create();

        //Create 5 products links to this category
        Product::factory()->count(5)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/products');
        $response->assertStatus(200);
    }

    public function test_can_list_all_products_by_category()
    {
        //Creat two different categories
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        //creat products in each category
        Product::factory()->count(5)->create(['category_id' => $category1->id]);
        Product::factory()->count(5)->create(['category_id' => $category2->id]);

        //call api to get products filter by specific category
        $response = $this->getJson("/api/products/$category1->id");
        $response->assertStatus(200);
    }
    public function test_can_create_new_product()
    {
        Storage::fake('public');

        $category = Category::factory()->create();
        $fakeImage = UploadedFile::fake()->image('image.png', 150, 150);

        $data = [
            "name" => "Test Product",
            "price" => 15.90,
            "image" => $fakeImage,
            "category_id" => $category->id,
        ];

        $response = $this->postJson("/api/products", $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas("products", [
            "name" => "Test Product",
            "price" => 15.90,
            "category_id" => $category->id,
        ]);
    }

    public function test_can_show_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $response = $this->getJson("/api/products/$product->id");
        $response->assertStatus(200);
    }

    public function test_can_update_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            "price" => 10.99,
        ]);
        $data = [
            "price" => 15.90,
        ];
        $response = $this->patchJson("/api/products/$product->id", $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas("products", $data);
    }

    public function test_fail_to_create_new_product()
    {
        $data = [
            "name" => "Test Product",
            "price" => -15.90,
            "image" => "products/blabla.png",
            "category_id" => 700,
        ];
        $response = $this->postJson("/api/products", $data);
        $response->assertStatus(422);
    }

    public function test_can_delete_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->deleteJson("/api/products/$product->id");

        //Check in database to see if the product is missing
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $response->assertSuccessful();
    }
}
