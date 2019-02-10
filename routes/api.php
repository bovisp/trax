<?php

Route::post('auth/register', 'Auth\Api\RegisterController@register');
Route::post('auth/login', 'Auth\Api\LoginController@login');
Route::post('auth/logout', 'Auth\Api\LogoutController@logout');
Route::get('auth/me', 'Auth\Api\MeController@me')->middleware(['auth:api']);;

Route::get('roles', 'RolesController@index')->middleware(['auth:api', 'role:administrator']);
Route::post('roles', 'RolesController@store')->middleware(['auth:api', 'role:administrator']);

Route::get('categories', 'CategoriesController@index');
Route::post('categories', 'CategoriesController@store')->middleware(['auth:api', 'role:administrator']);
