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

Route::get('/social/', 'Stream@view');

Route::get('/stream/', 'Stream@view');

Route::get('/swiss/', function () {
    return view('pages/swiss');
});

Route::get('/linktree/', function () {
    return view('pages/linktree');
});

Route::get('/alphabet/', function () {
    return view('pages/alphabet');
});