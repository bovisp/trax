<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function login()
    {
    	$user = request()->validate([
    		'email' => 'email|required|exists:users,email',
    		'password' => 'required'
    	]);

    	if (!$token = auth()->attempt(request(['email', 'password']))) {
    		return response()->json([
    			'errors' => [
    				'message' => [
    					'Sorry we couldn\'t sign you in with those details'
    				]
    			]
    		], 422);
    	}

        return (new UserResource(request()->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }
}
