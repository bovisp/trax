<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
	public function index()
	{
		$categories = Category::all();

		return view('categories.index', compact('categories'));
	}

	public function create()
	{
		return view('categories.create');
	}

    public function store()
    {
    	request()->validate([
    		'name' => 'required|min:3'
    	]);

    	Category::create(request(['name']));

    	return redirect('/categories');
    }
}
