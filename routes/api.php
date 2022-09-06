<?php

use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::name('api.')
    ->group(function () {
        Route::apiResource('users', UsersController::class);
        Route::apiResource('regions', RegionController::class);
        Route::apiResource('countries', CountryController::class);
    });
