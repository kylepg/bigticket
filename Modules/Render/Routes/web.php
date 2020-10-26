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

Route::prefix('render')->group(function () {
    Route::get('/', 'RenderController@index');
    Route::prefix('team')->group(function () {
        Route::get('/career-center', 'RenderController@careerCenter');
        Route::get('/career-center/blog/{blog}', 'RenderController@careerCenterBlog');
    });
    Route::get('/draft', 'RenderController@draft');
});
