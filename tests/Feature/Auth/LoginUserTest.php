<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginUserTest extends TestCase
{
	use DatabaseMigrations;

    public function test_it_requires_an_email()
    {
        $this->json('POST', 'api/auth/login')
        	->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $this->json('POST', 'api/auth/login')
        	->assertJsonValidationErrors(['password']);
    }

    public function test_it_returns_a_validation_error_if_credentials_dont_match()
    {
    	$user = factory(User::class)->create();
        $this->json('POST', 'api/auth/login', [
        	'email' => $user->email,
        	'password' => 'notmypassword'
        ])
        	->assertJsonValidationErrors(['message']);
    }

    public function test_it_returns_a_token_if_credentials_do_match()
    {
    	$user = factory(User::class)->create();

        $this->json('POST', 'api/auth/login', [
        	'email' => $user->email,
        	'password' => 'secret'
        ])
        	->assertJsonStructure([
        		'meta' => [
        			'token'
        		]
        	]);
    }

    public function test_it_returns_a_user_if_credentials_do_match()
    {
    	$user = factory(User::class)->create();

        $this->json('POST', 'api/auth/login', [
        	'email' => $user->email,
        	'password' => 'secret'
        ])
        	->assertJsonFragment([
        		'email' => $user->email
        	]);
    }
}
