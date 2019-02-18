<?php

namespace Tests\Feature\Categories;

use App\Category;
use Tests\TestCase;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryIndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cannot_view_categories()
    {
        $this->json('GET', 'api/categories')
            ->assertStatus(401);
    }

    /** @test */
    public function non_administrators_cannot_view_categories()
    {
        $user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

        $this->be($user);

        $this->jsonAs(auth()->user(), 'GET', 'api/categories')
            ->assertStatus(403);
    }

    /** @test */
    public function an_administrator_can_view_categories()
    {
        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $category = factory(Category::class)->create();

        $this->jsonAs(auth()->user(), 'GET', 'api/categories')
            ->assertJsonFragment([
                'id' => $category->id,
                'name' => $category->name
            ]);
    }

    /** @test */
    public function it_returns_a_collection_of_categories()
    {
        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $categories = factory(Category::class, 2)->create();

        $response = $this->json('GET', 'api/categories');

        $categories->each(function ($category) use ($response) {
            $response->assertJsonFragment([
                'name' => $category->name
            ]);
        });
    }

    /** @test */
    public function it_returns_only_parent_categories()
    {
        $this->withoutExceptionHandling();

        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $category = factory(Category::class)->create();

        $childCategory = $category->children()->save(
            factory(Category::class)->create()
        );

        $this->json('GET', 'api/categories')
            ->assertJsonCount(1, 'data');
    }
}