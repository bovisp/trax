<?php

namespace Tests\Feature\Roles;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleIndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cannot_view_the_roles_index_page()
    {
    	$this->get('roles')
    		->assertRedirect('/login');
    }

    /** @test */
    public function only_adfministrators_can_view_the_roles_index_page()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'not_administrator',
    		'display_name' => 'Not Administrator'
       	]);

    	$user->assignRole('not_administrator');

    	$this->be($user);

    	$this->get('roles')
    		->assertStatus(403);
    }

    /** @test */
    public function an_administrator_can_view_roles()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => $name = 'administrator',
    		'display_name' => 'Administrator'
       	]);

    	$user->assignRole('administrator');

    	$this->be($user);

    	$this->get('roles')
    		->assertSee($name);
    }
}
