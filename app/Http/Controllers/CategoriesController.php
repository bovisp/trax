<?php

namespace App\Http\Controllers;

use App\Category;
use App\Rules\CategoryParentId;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
	public function index()
	{
		return CategoryResource::collection(
			Category::with('children')->with('parent')->parents()->ordered()->get()
		);
	}

	public function store()
    {    	
    	request()->validate([
    		'name' => 'required|min:3',
            'parent_id' => 'sometimes|exists:categories,id'
    	]);

    	$category = Category::create(request(['name', 'parent_id']));

    	return (new CategoryResource($category))
    		->additional([
    			'message' => 'Category successfully created.'
    		]);
    }

    public function show(Category $category)
    {
        $category->load(['children', 'parent']);

        return new CategoryResource($category);
    }

    public function edit(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Category $category)
    {
        request()->validate([
            'name' => 'sometimes|required|min:3',
            'parent_id' => [
                'sometimes',
                new CategoryParentId
            ]
        ]);

        $category->update(request(['name', 'parent_id']));

        if ($category->children->count() && !is_null($category->parent_id)) {
            $category->children
                ->each(function ($category) {
                    $category->update([
                        'parent_id' => null
                    ]);
                });
        }

        return (new CategoryResource($category))
            ->additional([
                'message' => 'Category successfully updated.'
            ]);
    }
}
