<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
	public function index()
	{
		$roles = Role::all();

		return view('roles.index', compact('roles'));
	}

    public function create()
    {
    	return view('roles.create');
    }

    public function store()
    {
    	request()->validate([
    		'name' => 'required|min:3|unique:roles,name',
    		'display_name' => 'required|min:3'
    	]);

    	Role::create(request(['name', 'display_name']));

    	return redirect('/roles');
    }
}
