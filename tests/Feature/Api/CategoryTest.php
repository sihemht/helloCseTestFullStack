<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_list_all_categories(){

        Category::factory()->count(5)->create();
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);
    }


    public function test_can_create_a_category()
    {
        $data = [
            "name" => "New Category",
        ];
        $response = $this->postJson('/api/categories', $data);
        $response->assertStatus(201);
    }


    public function test_fails_to_create_category(){

        $response = $this->postJson('/api/categories', []);
        $response->assertStatus(422);
    }


    public function test_can_show_a_category()
    {
        //Creat category with specific name
        $category = Category::factory()->create(["name" => "Fashion"]);
        $response = $this->getJson("/api/categories/$category->id");
        $response->assertStatus(200);
    }


    public function test_can_update_a_category()
    {
        //Creat category with specific name
        $category = Category::factory()->create(['name' => 'Old Name']);

        //recover category that we created and update the name
        $response = $this->patchJson("/api/categories/$category->id", [
            'name' => 'New Name'
        ]);
        //Insert in database after updated
        $this->assertDatabaseHas('categories', [
            'name' => 'New Name',
            'id' => $category->id,
        ]);
        $response->assertStatus(200);
  }


    public function test_can_delete_a_category(): void
    {
        $category = Category::factory()->create();
        $response = $this->deleteJson("/api/categories/$category->id");
        //server responded with a success HTTP code
        $response->assertSuccessful();

        //Line corresponding to the ID of our category
        //has disappeared from the categories table.
        $this->assertDatabaseMissing('categories',['id'=>$category->id]);
    }
}
