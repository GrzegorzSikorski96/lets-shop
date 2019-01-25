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

Route::post("/login", "API\Auth\AuthController@login")->name("login");
Route::post("/register", "API\Auth\RegisterController@register")->name("register");

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post("/logout", "API\Auth\AuthController@logout")->name("logout");

    Route::get("/group/{group_id}", "API\GroupController@getGroup")->where('group_id', '[0-9]+');
    Route::get("/groups", "API\GroupController@getGroups");
    Route::post("/group", 'API\GroupController@createGroup');
    Route::post("/group/{group_id}/remove", "API\GroupController@removeGroup")->where('group_id', '[0-9]+');
    Route::post("/invite/{group_id}", "API\GroupController@invite")->where('group_id', '[0-9]+');
    Route::post("/kick/{group_id}", "API\GroupController@invite")->where('group_id', '[0-9]+');

    Route::get("/lists/{group_id}", "API\ListController@getGroupLists")->where('group_id', '[0-9]+');
    Route::get("/list/{list_id}", "API\ListController@getList")->where('list_id', '[0-9]+');
    Route::post('/list/{group_id}', "API\ListController@createList")->where('group_id', '[0-9]+');

    Route::post('product/{group_id}/shop', 'API\ProductController@addShop')->where('group_id', '[0-9]+');
});


Route::fallback(function (\App\Helpers\APIResponse $response) {
    return $response
        ->setMessage(__('messages.not.found'))
        ->setFailureStatus(404)
        ->getLogoutResponse();
});