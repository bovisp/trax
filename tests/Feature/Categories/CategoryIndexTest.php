<?php

namespace Tests\Feature\Categories;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_user_can_view_categories()
    {
    	$category = factory(Category::class)->create();

    	$this->json('GET', 'api/categories')
    		->assertJsonFragment([
                'id' => $category->id,
                'name' => $category->name
            ]);
    }
}
