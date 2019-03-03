<?php

namespace Tests\Feature\Roles;

use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Facades\Tests\Assignments\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RoleShowTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cannot_view_individual_roles()
    {
        $this->json('GET', 'api/roles/1')
            ->assertStatus(401);
    }

    /** @test */
    public function non_administrators_cannot_view_individual_roles()
    {
    	// $this->withoutExceptionHandling();

    	$user = UserFactory::withRole('not_administrator', 'Not Administrator')
            ->create();

        $this->be($user);

    	$this->jsonAs(auth()->user(), 'GET', 'api/roles/1')
    		->assertStatus(403);
    }

    /** @test */
    public function administrators_can_view_individual_roles()
    {
    	$this->withoutExceptionHandling();

    	$user = UserFactory::withRole('administrator', 'Administrator')
            ->create();

        $this->be($user);

        $role = factory(Role::class)->create();

    	$this->jsonAs(auth()->user(), 'GET', "api/roles/{$role->id}")
    		->assertJsonFragment([
    			'id' => $role->id,
    			'name' => $role->name
    		]);
    }
}
