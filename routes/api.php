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

    $api->get('lists', '\App\Http\Controllers\Api\ListController@index');
    $api->post('lists', '\App\Http\Controllers\Api\ListController@store');
    $api->get('lists/{id}', '\App\Http\Controllers\Api\ListController@show');
    $api->patch('lists/{id}', '\App\Http\Controllers\Api\ListController@update');
    $api->delete('lists/{id}', '\App\Http\Controllers\Api\ListController@destroy');
});



