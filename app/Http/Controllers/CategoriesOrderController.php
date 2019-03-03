<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoriesOrderController extends Controller
{
    public function update()
    {
    	foreach (request()->all() as $category) {
    		$categoryToBeUpdated = Category::find($category['id']);

    		$categoryToBeUpdated->update([
    			'order' => $category['order']
    		]);
    	}

    	return (CategoryResource::collection(
    				Category::with('children')->with('parent')->parents()->ordered()->get()
		))->additional([
    		'message' => 'Categories order updated.'
		]);
    }
}
