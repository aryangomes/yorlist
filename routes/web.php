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
/*Route::get('lists', '\App\Http\Controllers\Api\ListController@index');
Route::post('lists', '\App\Http\Controllers\Api\ListController@store');
Route::get('lists/{id}', '\App\Http\Controllers\Api\ListController@show');
Route::patch('lists/{id}', '\App\Http\Controllers\Api\ListController@update');
Route::delete('lists/{id}', '\App\Http\Controllers\Api\ListController@destroy');
Route::post('lists/clone-list', '\App\Http\Controllers\Api\ListController@cloneList');*/

Route::prefix('api')->group(function () {
    //List

    Route::get('lists/{id}/items', '\App\Http\Controllers\Api\ListController@items');

    //ListHasItem
    Route::post('lists/additem', '\App\Http\Controllers\Api\ListController@addItem');
    Route::post('lists/removeitem', '\App\Http\Controllers\Api\ListController@removeItem');
    Route::put('lists/updateiteminlist', '\App\Http\Controllers\Api\ListController@updateItemInList');
    Route::resource('lists', '\App\Http\Controllers\Api\ListController');

    //Items
    Route::resource('items', '\App\Http\Controllers\Api\ItemController');

    Route::post('items/search', '\App\Http\Controllers\Api\ItemController@search');
    Route::post('items/search-by-category', '\App\Http\Controllers\Api\ItemController@searchByCategory');

    Route::put('listhasitems',['as'=> 'api.listhasitems.update' , 'uses' =>'\App\Http\Controllers\Api\ListHasItemController@update']);
});


//User
Route::patch('user', '\App\Http\Controllers\Api\UserController@update');
Route::delete('user', '\App\Http\Controllers\Api\UserController@destroy');


Route::get('/home', 'HomeController@index')->name('home');
