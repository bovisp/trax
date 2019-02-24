<?php

namespace Tests\Feature\Categories;

use App\Category;
use Tests\TestCase;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryEditTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cannot_view_a_json_response_that_is_intended_for_a_category_edit_page()
    {
    	$this->json('GET', 'api/categories/1/edit')
            ->assertStatus(401);
    }

    /** @test */
    public function non_administrators_cannot_view_a_json_response_that_is_intended_for_a_category_edit_page()
    {
        $user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

        $this->be($user);

        $category = factory(Category::class)->create();

        $this->jsonAs(auth()->user(), 'GET', "api/categories/{$category->id}/edit")
            ->assertStatus(403);
    }

    /** @test */
    public function administrators_can_view_a_json_response_that_is_intended_for_a_category_edit_page()
    {
    	$this->withoutExceptionHandling();
    	
        $user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $category = factory(Category::class)->create();

        $this->jsonAs(auth()->user(), 'GET', "api/categories/{$category->id}/edit")
            ->assertJsonFragment([
            	'id' => $category->id,
            	'name' => $category->name
            ]);
    }
}
