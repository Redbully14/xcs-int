<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| Basic Bitch Documentation:
| https://antelope.docs.apiary.io/
*/

Route::post('/', function () {
    return (new \App\Http\Resources\ApiError(['message' => 'No Api version provided.']))->response()->setStatusCode(400);
});

Route::prefix('v1')->namespace('API')->group(function () {
    Route::post('/', function () {
        return (new \App\Http\Resources\ApiError(['message' => 'No endpoint provided.']))->response()->setStatusCode(400);
    });

    Route::post('/{endpoint}/{argument}/{argument2}', 'ApiEndpointController@interpret')->middleware('throttle');

    Route::post('/{endpoint}/{argument}', 'ApiEndpointController@interpret')->middleware('throttle');

    Route::post('/{endpoint}', 'ApiEndpointController@interpret')->middleware('throttle');
});
