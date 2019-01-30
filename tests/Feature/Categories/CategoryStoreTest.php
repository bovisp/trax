<?php

namespace Tests\Feature\Categories;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

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
		$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'not_administrator',
    		'display_name' => 'Not Administrator'
       	]);

    	$user->assignRole($role);

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
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole($role);

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
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole($role);

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
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole($role);

    	$this->be($user);

    	$attributes = [
    		'name' => 'b'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/categories', $attributes)
    		->assertJsonValidationErrors(['name']);
    }
}
