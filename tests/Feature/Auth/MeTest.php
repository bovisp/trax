<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_fails_if_a_user_isnt_authenticated()
    {
        $this->json('GET', 'api/auth/me')
        	->assertStatus(401);
    }

    /** @test */
    public function it_returns_user_details()
    {
    	$user = factory(User::class)->create();
    	
        $this->jsonAs($user, 'GET', 'api/auth/me')
        	->assertJsonFragment([
        		'email' => $user->email
        	]);
    }
}
