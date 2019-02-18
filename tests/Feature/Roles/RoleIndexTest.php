<?php

namespace Tests\Feature\Roles;

use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
    	$user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

        $this->be($user);

    	$this->jsonAs(auth()->user(), 'GET', 'api/roles')
    		->assertStatus(403);
    }

    /** @test */
    public function an_administrator_can_view_roles()
    {
    	$user = UserFactory::withRole($name = 'administrator', $displayName = 'Administrator')
            ->create();

    	$this->be($user);

        $role = factory(Role::class)->create();

    	$this->jsonAs(auth()->user(), 'GET', 'api/roles')
    		->assertJsonFragment([
                'name' => $role->name,
                'display_name' => $role->display_name
            ]);
    }
}
