<?php

namespace Tests\Feature\Roles;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

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
		$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'not_administrator',
    		'display_name' => 'Not Administrator'
       	]);

    	$user->assignRole($role);

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
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole($role);

    	$this->be($user);

    	$attributes = [
    		'name' => 'some_role',
    		'display_name' => 'Some role'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'roles', $attributes)
            ->assertJsonFragment($attributes);

        $this->assertDatabaseHas('roles', $attributes);
    }

    /** @test */
    public function a_role_requires_a_name()
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

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_role_requires_a_name_to_be_at_least_three_characters_in_length()
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

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_role_must_have_a_unique_name()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => $roleName = 'administrator',
    		'display_name' => $roleDisplayName = 'Administrator'
       	]);

    	$user->assignRole($role);

    	$this->be($user);

    	$attributes = [
    		'name' => $roleName,
    		'display_name' => $roleDisplayName
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_role_requires_a_display_name()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole($role);

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
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole($role);

    	$this->be($user);

    	$attributes = [
    		'display_name' => 'b'
    	];

    	$this->jsonAs(auth()->user(), 'POST', 'api/roles', $attributes)
    		->assertJsonValidationErrors(['display_name']);
    }
}
