<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.auth'], function ($api) {

    //Lists
    $api->get('lists', '\App\Http\Controllers\Api\ListController@index');
    $api->post('lists', '\App\Http\Controllers\Api\ListController@store');
    $api->get('lists/{id}', '\App\Http\Controllers\Api\ListController@show');
    $api->patch('lists/{id}', '\App\Http\Controllers\Api\ListController@update');
    $api->delete('lists/{id}', '\App\Http\Controllers\Api\ListController@destroy');


    //Items
    $api->get('items', '\App\Http\Controllers\Api\ItemController@index');
    $api->post('items', '\App\Http\Controllers\Api\ItemController@store');
    $api->get('items/{id}', '\App\Http\Controllers\Api\ItemController@show');
    $api->patch('items/{id}', '\App\Http\Controllers\Api\ItemController@update');
    $api->delete('items/{id}', '\App\Http\Controllers\Api\ItemController@destroy');


    //User
    $api->patch('user', '\App\Http\Controllers\Api\UserController@update');
    $api->delete('user', '\App\Http\Controllers\Api\UserController@destroy');

    //ListHasItem
    $api->post('lists/additem', '\App\Http\Controllers\Api\ListController@addItem');
    $api->post('lists/removeitem', '\App\Http\Controllers\Api\ListController@removeItem');

});

$api->version('v1', function ($api) {

    //Register user
    $api->post('register', '\App\Http\Controllers\Api\RegisterController@create');





});


