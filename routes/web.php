<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('roles', 'RolesController@index')->middleware(['role:administrator', 'auth']);
Route::get('roles/create', 'RolesController@create')->middleware(['role:administrator', 'auth']);
Route::post('roles', 'RolesController@store')->middleware(['role:administrator', 'auth']);

Route::get('categories', 'CategoriesController@index');
Route::get('categories/create', 'CategoriesController@create')->middleware(['role:administrator', 'auth']);
Route::post('categories', 'CategoriesController@store')->middleware(['role:administrator', 'auth']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
