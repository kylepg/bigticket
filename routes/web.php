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

Route::get('login', 'Auth\LoginController@redirectToAzure')->name('login');
Route::get('login/callback', 'Auth\LoginController@handleAzureCallback')->name('loginCallback');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', function () {
    if(\Auth::check()){
        dd(\Auth::user());
    }
    return view('welcome');
});

Route::get('modules',function(){
    dd(collect([]));
});
