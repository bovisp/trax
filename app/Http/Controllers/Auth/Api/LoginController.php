<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login()
    {
    	request()->validate([
    		'email' => 'email|required|exists:users,email',
    		'password' => 'required'
    	]);

    	if (!$token = auth()->attempt(request(['email', 'password']))) {
    		return response()->json([
    			'errors' => [
    				'email' => [
    					'Sory we couldn\'t sign you in with those details'
    				]
    			]
    		], 422);
    	}
    }
}
