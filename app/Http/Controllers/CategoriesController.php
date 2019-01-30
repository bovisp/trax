<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
	public function index()
	{
		return CategoryResource::collection(
			Category::all()
		);
	}

	public function store()
    {    	
    	request()->validate([
    		'name' => 'required|min:3'
    	]);

    	$category = Category::create(request(['name']));

    	return new CategoryResource($category);
    }
}
