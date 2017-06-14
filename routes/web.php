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

Auth::routes();


//Lists
Route::get('lists', '\App\Http\Controllers\Api\ListController@index');
Route::post('lists', '\App\Http\Controllers\Api\ListController@store');
Route::get('lists/{id}', '\App\Http\Controllers\Api\ListController@show');
Route::patch('lists/{id}', '\App\Http\Controllers\Api\ListController@update');
Route::delete('lists/{id}', '\App\Http\Controllers\Api\ListController@destroy');
Route::post('lists/clone-list', '\App\Http\Controllers\Api\ListController@cloneList');


//Items
Route::get('items', '\App\Http\Controllers\Api\ItemController@index');
Route::post('items', '\App\Http\Controllers\Api\ItemController@store');
Route::get('items/{id}', '\App\Http\Controllers\Api\ItemController@show');
Route::patch('items/{id}', '\App\Http\Controllers\Api\ItemController@update');
Route::delete('items/{id}', '\App\Http\Controllers\Api\ItemController@destroy');
Route::post('items/search', '\App\Http\Controllers\Api\ItemController@search');
Route::post('items/search-by-category', '\App\Http\Controllers\Api\ItemController@searchByCategory');


//User
Route::patch('user', '\App\Http\Controllers\Api\UserController@update');
Route::delete('user', '\App\Http\Controllers\Api\UserController@destroy');

//ListHasItem
Route::post('lists/additem', '\App\Http\Controllers\Api\ListController@addItem');
Route::post('lists/removeitem', '\App\Http\Controllers\Api\ListController@removeItem');
Route::put('lists/updateiteminlist', '\App\Http\Controllers\Api\ListController@updateItemInList');


Route::get('/home', 'HomeController@index')->name('home');
