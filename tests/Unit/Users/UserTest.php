<?php

namespace Tests\Unit\Users;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_have_roles()
    {
    	$user = factory(User::class)->create();

    	$role = factory(Role::class)->create();

    	$user->assignRole($role);

    	$this->assertInstanceOf(Role::class, $user->roles->first());
    }
}
