<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
	public function index()
	{
		return RoleResource::collection(
            Role::all()
        );
	}

    public function store()
    {
    	request()->validate([
    		'name' => 'required|min:3|unique:roles,name',
    		'display_name' => 'required|min:3'
    	]);

    	$role = Role::create(request(['name', 'display_name']));

    	return (new RoleResource($role))
            ->additional([
                'message' => 'Role successfully created'
            ]);
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }
}
