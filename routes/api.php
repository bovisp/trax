<?php

Route::post('register', 'Auth\Api\RegisterController@register');
Route::post('login', 'Auth\Api\LoginController@login');
