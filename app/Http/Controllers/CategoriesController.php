<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
	public function index()
	{
		return CategoryResource::collection(
			Category::with('children')->parents()->get()
		);
	}

	public function store()
    {    	
    	request()->validate([
    		'name' => 'required|min:3'
    	]);

    	$category = Category::create(request()->only(['name', 'parent_id']));

    	return (new CategoryResource($category))
    		->additional([
    			'message' => 'Category successfully created.'
    		]);
    }

    public function show(Category $category)
    {
        $category->load(['children']);

        return new CategoryResource($category);
    }
}
