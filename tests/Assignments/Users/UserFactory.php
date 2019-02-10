<?php

namespace Tests\Assignments;

use App\User;
use Spatie\Permission\Models\Role;

class UserFactory
{
	protected $user;

	public function __construct()
	{
		$this->user = factory(User::class)->create();
	}

	public function create()
	{
		return $this->user;
	}

	public function withRole($name, $display_name)
	{
		$role = factory(Role::class)->create(compact('name', 'display_name'));

    	$this->user->assignRole($role);

    	return $this;
	}
}