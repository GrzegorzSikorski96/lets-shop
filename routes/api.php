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

Route::fallback(function (\App\Helpers\APIResponse $response) {
    return $response
        ->setMessage(__('messages.not.found'))
        ->setFailureStatus(404)
        ->getLogoutResponse();
});