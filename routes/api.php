<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function () {
    Route::options('/plant/create', 'App\Http\Controllers\PlantController@create')->name('plant.create.form');
    Route::post('/plant/create', 'App\Http\Controllers\PlantController@store')->name('plant.create.store');
});
