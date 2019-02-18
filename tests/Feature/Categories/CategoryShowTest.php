<?php

namespace Tests\Feature\Categories;

use App\Category;
use Tests\TestCase;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryShowTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cannot_view_a_category()
    {
    	$this->json('GET', 'api/categories/1')
            ->assertStatus(401);
    }

    /** @test */
    public function non_administrators_cannot_view_a_category()
    {
        $user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

        $this->be($user);

        $category = factory(Category::class)->create();

        $this->jsonAs(auth()->user(), 'GET', "api/categories/{$category->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function administrators_can_view_a_category()
    {
    	$this->withoutExceptionHandling();
    	
        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $category = factory(Category::class)->create();

        $this->jsonAs(auth()->user(), 'GET', "api/categories/{$category->id}")
            ->assertJsonFragment([
            	'id' => $category->id,
            	'name' => $category->name
            ]);
    }
}
