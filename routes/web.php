<?php

use Illuminate\Support\Facades\Route;

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
    return view('pages/projects');
});

Route::get('/media/', 'MediaController@view');

Route::get('/swiss/', function () {
    return view('pages/swiss');
});

Route::get('/socials/', function () {
    return view('pages/socials');
});

Route::get('/alphabet/', function () {
    return view('pages/alphabet');
});

Route::get('/jsframework/', function () {
    return view('pages/jsframework');
});

Route::get('/jsframework/vanilla/', function () {
    return view('components/jsframework/vanilla');
});

Route::get('/blog/login/', 'LoginController@view');

Route::post('/blog/login/validate', 'LoginController@validateLogin')
    ->middleware('guest', 'throttle:3,5');

Route::get('/blog/', 'BlogController@view');
Route::get('/blog/{id}', 'BlogController@viewPage');

Route::get('/blog/post/{id}', 'BlogController@viewPost');

Route::post('/blog/add/', 'BlogController@add');

Route::post('/blog/edit/{id}/', 'BlogController@edit');