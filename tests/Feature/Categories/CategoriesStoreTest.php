<?php

namespace Tests\Feature\Categories;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoriesStoreTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_cannot_view_the_create_categories_page()
	{
		$this->get('categories/create')
    		->assertRedirect('/login');
	}

	/** @test */
	public function guests_cannot_create_categories()
	{		
		$this->post('categories')
    		->assertRedirect('/login');
	}

	/** @test */
	public function only_administrators_can_view_the_create_categories_page()
	{
		$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'not_administrator',
    		'display_name' => 'Not Administrator'
       	]);

    	$user->assignRole('not_administrator');

    	$this->be($user);

    	$this->get('categories/create')
    		->assertStatus(403);
	}

	/** @test */
	public function only_administrators_can_create_categories()
	{
		$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'not_administrator',
    		'display_name' => 'Not Administrator'
       	]);

    	$user->assignRole('not_administrator');

    	$this->be($user);

    	$attributes = [
    		'name' => 'Category 1'
    	];

    	$this->post('categories', $attributes)
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

    	$user->assignRole('administrator');

    	$this->be($user);

    	$this->get('categories/create')
    		->assertStatus(200);

    	$attributes = [
    		'name' => 'Category 1'
    	];

    	$response = $this->post('categories', $attributes);

    	$category = Category::where($attributes)->first();

    	$response->assertRedirect('/categories');

    	$this->get('categories')
    		->assertSee($category->name);
    }

    /** @test */
    public function a_category_requires_a_name()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole('administrator');

    	$this->be($user);

    	$attributes = [
    		'name' => ''
    	];

    	$this->post('categories', $attributes)
    		->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_category_requires_a_name_to_be_at_least_three_characters_in_length()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole('administrator');

    	$this->be($user);

    	$attributes = [
    		'name' => 'b'
    	];

    	$this->post('categories', $attributes)
    		->assertSessionHasErrors(['name']);
    }
}
