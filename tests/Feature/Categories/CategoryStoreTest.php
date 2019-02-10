<?php

namespace Tests\Feature\Categories;

use App\User;
use App\Category;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryStoreTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_cannot_create_categories()
	{		
		$this->json('POST', 'api/categories')
    		->assertStatus(401);
	}

	/** @test */
	public function only_administrators_can_create_categories()
	{
		$user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => 'Category 1'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/categories', $attributes)
    		->assertStatus(403);
	}

    /** @test */
    public function an_administrator_can_create_categories()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => 'Category 1'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/categories', $attributes)
            ->assertJsonFragment($attributes);
    }

    /** @test */
    public function a_category_requires_a_name()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => ''
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/categories', $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_category_requires_a_name_to_be_at_least_three_characters_in_length()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => 'b'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/categories', $attributes)
    		->assertJsonValidationErrors(['name']);
    }
}
