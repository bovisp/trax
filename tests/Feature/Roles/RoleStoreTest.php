<?php

namespace Tests\Feature\Roles;

use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RoleStoreTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function guests_cannot_create_roles()
	{		
		$this->json('POST', 'api/roles')
    		->assertStatus(401);
	}

	/** @test */
	public function only_administrators_can_create_roles()
	{
		$user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => 'some_role',
    		'display_name' => 'Some role'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertStatus(403);
	}

    /** @test */
    public function an_administrator_can_create_roles()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => 'some_role',
    		'display_name' => 'Some role'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
            ->assertJsonFragment($attributes);

        $this->assertDatabaseHas('roles', $attributes);
    }

    /** @test */
    public function a_role_requires_a_name()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => ''
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_role_requires_a_name_to_be_at_least_three_characters_in_length()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => 'b'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_role_must_have_a_unique_name()
    {
    	$user = UserFactory::withRole($name = 'administrator', $displayName = 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'name' => $name,
    		'display_name' => $displayName
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_role_requires_a_display_name()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'display_name' => ''
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['display_name']);
    }

    /** @test */
    public function a_role_requires_a_display_name_to_be_at_least_three_characters_in_length()
    {
    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

    	$this->be($user);

    	$attributes = [
    		'display_name' => 'b'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['display_name']);
    }
}
