<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function logout()
    {
    	auth()->logout();
    }
}
