<?php

use Illuminate\Http\Request;

Route::get('/users','AuthController@show');
Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');
