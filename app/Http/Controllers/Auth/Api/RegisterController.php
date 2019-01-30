<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{
    public function register()
    {
    	request()->validate([
    		'email' => 'email|required|unique:users,email',
    		'name' => 'required',
    		'password' => 'required'
    	]);

    	$user = User::create([
    		'email' => request('email'),
    		'name' => request('name'),
    		'password' => bcrypt(request('password'))
    	]);

    	if (!$token = auth()->attempt(request(['email', 'password']))) {
            return abort(401);
        }

        return (new UserResource(request()->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }
}
