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


});


Route::fallback(function (\App\Helpers\APIResponse $response) {
    return $response
        ->setMessage(__('messages.not.found'))
        ->setFailureStatus(404)
        ->getLogoutResponse();
});