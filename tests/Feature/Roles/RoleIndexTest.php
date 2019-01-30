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
    public function guests_cannot_view_roles()
    {
        $this->json('GET', 'api/roles')
            ->assertStatus(401);
    }

    /** @test */
    public function non_administrators_cannot_view_roles()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => 'not_administrator',
    		'display_name' => 'Not Administrator'
       	]);

    	$user->assignRole($role);

    	$this->be($user);

    	$this->jsonAs(auth()->user(), 'GET', 'api/roles')
    		->assertStatus(403);
    }

    /** @test */
    public function an_administrator_can_view_roles()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create([
    		'name' => $name = 'administrator',
    		'display_name' => $displayName = 'Administrator'
       	]);

    	$user->assignRole($role);

    	$this->be($user);

    	$this->jsonAs(auth()->user(), 'GET', 'api/roles')
    		->assertJsonFragment([
                'name' => $name,
                'display_name' => $displayName
            ]);
    }
}
