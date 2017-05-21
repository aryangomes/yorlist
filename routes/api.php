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

    $api->get('user', function () {
        $user = app('Dingo\Api\Auth\Auth')->user();

        return $user;
    });

    $api->get('lists', '\App\Http\Controllers\Api\ListController@index');
});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

