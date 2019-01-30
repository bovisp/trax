<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    public function me()
    {
    	return new UserResource(request()->user());
    }
}
