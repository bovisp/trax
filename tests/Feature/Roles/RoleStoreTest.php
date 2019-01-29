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
	public function guests_cannot_view_the_create_roles_page()
	{
		$this->get('roles/create')
    		->assertRedirect('/login');
	}

	/** @test */
	public function guests_cannot_create_roles()
	{		
		$this->post('roles')
    		->assertRedirect('/login');
	}

	/** @test */
	public function only_administrators_can_view_the_create_roles_page()
	{
		$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'not_administrator',
    		'display_name' => 'Not Administrator'
       	]);

    	$user->assignRole('not_administrator');

    	$this->be($user);

    	$this->get('roles/create')
    		->assertStatus(403);
	}

	/** @test */
	public function only_administrators_can_create_roles()
	{
		$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'not_administrator',
    		'display_name' => 'Not Administrator'
       	]);

    	$user->assignRole('not_administrator');

    	$this->be($user);

    	$attributes = [
    		'name' => 'some_role',
    		'display_name' => 'Some role'
    	];

    	$this->post('roles', $attributes)
    		->assertStatus(403);
	}

    /** @test */
    public function an_administrator_can_create_roles()
    {
    	$this->withoutExceptionHandling();

    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole('administrator');

    	$this->be($user);

    	$this->get('roles/create')
    		->assertStatus(200);

    	$attributes = [
    		'name' => 'some_role',
    		'display_name' => 'Some role'
    	];

    	$response = $this->post('roles', $attributes);

    	$role = Role::where($attributes)->first();

    	$response->assertRedirect('/roles');

    	$this->get('roles')
    		->assertSee($role->name);
    }

    /** @test */
    public function a_role_requires_a_name()
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

    	$this->post('roles', $attributes)
    		->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_role_requires_a_name_to_be_at_least_three_characters_in_length()
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

    	$this->post('roles', $attributes)
    		->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_role_must_have_a_unique_name()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => $roleName = 'administrator',
    		'display_name' => $roleDisplayName = 'Administrator'
       	]);

    	$user->assignRole('administrator');

    	$this->be($user);

    	$attributes = [
    		'name' => $roleName,
    		'display_name' => $roleDisplayName
    	];

    	$this->post('roles', $attributes)
    		->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_role_requires_a_display_name()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole('administrator');

    	$this->be($user);

    	$attributes = [
    		'display_name' => ''
    	];

    	$this->post('roles', $attributes)
    		->assertSessionHasErrors(['display_name']);
    }

    /** @test */
    public function a_role_requires_a_display_name_to_be_at_least_three_characters_in_length()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole('administrator');

    	$this->be($user);

    	$attributes = [
    		'display_name' => 'b'
    	];

    	$this->post('roles', $attributes)
    		->assertSessionHasErrors(['display_name']);
    }
}
