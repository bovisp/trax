<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterUserTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
    public function a_user_can_be_registered()
    {
    	$attributes = [
    		'name' => $name = 'Paul Bovis',
    		'email' => $email = 'bovisp@me.com',
    		'password' => 'secret'
    	];

    	$this->json('POST', 'api/auth/register', $attributes);

    	$this->assertDatabaseHas('users', compact('name', 'email'));
    }

    /** @test */
    public function a_users_information_and_auth_token_is_returned_after_registration()
    {
    	$attributes = [
    		'name' => $name = 'Paul Bovis',
    		'email' => $email = 'bovisp@me.com',
    		'password' => 'secret'
    	];

    	$this->json('POST', 'api/auth/register', $attributes)
    		->assertJsonFragment(compact('name', 'email'))
    		->assertJsonStructure([
				'meta' => [
					'token'
				]
    		]);
    }

    /** @test */
    public function a_user_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
        	->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_user_requires_an_email()
    {
        $this->json('POST', 'api/auth/register')
        	->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function a_user_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register', [
        	'email' => 'notanemail'
        ])
        	->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function a_user_requires_a_unique_email()
    {
    	$user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', [
        	'email' => $user->email
        ])
        	->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function a_user_requires_a_password()
    {
        $this->json('POST', 'api/auth/register')
        	->assertJsonValidationErrors(['password']);
    }
}
