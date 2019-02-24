<?php

namespace Tests\Feature\Categories;

use App\Category;
use Tests\TestCase;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateCategoriesTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_cannot_update_categories()
	{		
		$this->json('PATCH', 'api/categories/1')
    		->assertStatus(401);
	}

	/** @test */
	public function only_administrators_can_update_categories()
	{
		$user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

    	$this->be($user);

    	$category = factory(Category::class)->create();

    	$attributes = [
    		'name' => 'Category 1'
    	];

    	$this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$category->id}", $attributes)
    		->assertStatus(403);
	}
    
	/** @test */
    public function administrators_can_update_a_category_name()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

    	$category = factory(Category::class)->create();

    	$attributes = [
    		'name' => 'Updated name'
    	];

    	$response = $this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$category->id}", $attributes);

    	$this->assertDatabaseHas('categories', $attributes);

    	$response->assertJsonFragment($attributes);
    }

    /** @test */
    public function administrators_can_change_a_top_level_category_to_be_a_child_of_another_top_level_category()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

    	$topLevelCategory1 = factory(Category::class)->create([
    		'parent_id' => null
    	]);

    	$topLevelCategory2 = factory(Category::class)->create([
    		'parent_id' => null
    	]);

    	$attributes = [
    		'parent_id' => $topLevelCategory2->id
    	];

    	$response = $this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$topLevelCategory1->id}", $attributes);

    	$this->assertDatabaseHas('categories', [
    		'id' => $topLevelCategory1->id,
    		'parent_id' => $topLevelCategory2->id
    	]);

    	$response->assertJsonFragment($attributes);
    }

    /** @test */
    public function administrators_can_change_a_child_category_to_a_top_level_category()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

    	$topLevelCategory = factory(Category::class)->create([
    		'parent_id' => null
    	]);

    	$topLevelCategory->children()->save(
    		$childCategory = factory(Category::class)->create()
    	);

    	$attributes = [
    		'parent_id' => null
    	];

    	$response = $this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$childCategory->id}", $attributes);

    	$this->assertDatabaseHas('categories', [
    		'id' => $childCategory->id,
    		'parent_id' => null
    	]);

    	$response->assertJsonFragment($attributes);
    }

    /** @test */
    public function administrators_can_change_a_child_category_from_one_top_level_category_to_another()
    {
    	$this->withoutExceptionHandling();

    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

    	$topLevelCategory1 = factory(Category::class)->create([
    		'parent_id' => null
    	]);

    	$topLevelCategory2 = factory(Category::class)->create();

    	$topLevelCategory2->children()->save(
    		$childCategory = factory(Category::class)->create()
    	);

    	$attributes = [
    		'parent_id' => $topLevelCategory1->id
    	];

    	$response = $this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$childCategory->id}", $attributes);

    	$this->assertDatabaseHas('categories', [
    		'id' => $childCategory->id,
    		'parent_id' => $topLevelCategory1->id
    	]);

    	$response->assertJsonFragment($attributes);
    }

    /** @test */
    public function an_updated_category_sometimes_requires_a_name()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$category = factory(Category::class)->create();

    	$attributes = [
    		'name' => ''
    	];

    	$this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$category->id}", $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function an_updated_category_sometimes_requires_a_name_to_be_at_least_three_characters_in_length()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$category = factory(Category::class)->create();

    	$attributes = [
    		'name' => 'b'
    	];

    	$this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$category->id}", $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function when_the_parent_id_is_being_updated_it_can_be_nullable()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$category = factory(Category::class)->create();

    	$attributes = [
    		'parent_id' => null
    	];

    	$this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$category->id}", $attributes)
    		->assertOK();
    }

    /** @test */
    public function when_the_parent_id_is_being_updated_it_must_match_a_category_id_if_it_is_not_null()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$category = factory(Category::class)->create();

    	$attributes = [
    		'parent_id' => 999999
    	];

    	$this->jsonAs(auth()->user(), 'PATCH', "api/categories/{$category->id}", $attributes)
    		->assertJsonValidationErrors(['parent_id']);
    }
}
