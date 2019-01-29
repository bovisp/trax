<?php

namespace Tests\Feature\Categories;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Contracts\Role;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_can_view_the_roles_index_page()
    {
    	$this->get('categories')
    		->assertStatus(200);
    }

    /** @test */
    public function an_user_can_view_categories()
    {
    	$category = factory(Category::class)->create();

    	$this->get('categories')
    		->assertSee($category->name);
    }
}
