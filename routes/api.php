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

/**
 * Webdomain: /api/
 *
 * @author Christopher M.
 * @package POST
 * @access Public
 * @version 1.0.0
 */
Route::post('/', function () {
    return (new \App\Http\Resources\ApiError(['message' => 'No Api version provided.']))->response()->setStatusCode(400);
});

/*
|--------------------------------------------------------------------------
| Route Group: api
| Category Name: v1ApiRoutes
|--------------------------------------------------------------------------
|
*/

Route::prefix('v1')->namespace('API')->group(function () {
    /**
     * Webdomain: /api/v1/
     *
     * @author Christopher M.
     * @package POST
     * @category v1ApiRoutes
     * @access Public
     * @version 1.0.0
     */

    Route::post('/', function () {
        return (new \App\Http\Resources\ApiError(['message' => 'No endpoint provided.']))->response()->setStatusCode(400);
    });

    /**
     * Webdomain: /api/v1/{any}/{any}/{any}
     *
     * @author Christopher M.
     * @package POST
     * @category v1ApiRoutes
     * @access Api Token
     * @version 1.0.0
     */

    Route::post('/{endpoint}/{argument}/{argument2}', 'ApiEndpointController@interpret')->middleware('throttle');

    /**
     * Webdomain: /api/v1/{any}/{any}
     *
     * @author Christopher M.
     * @package POST
     * @category v1ApiRoutes
     * @access Api Token
     * @version 1.0.0
     */

    Route::post('/{endpoint}/{argument}', 'ApiEndpointController@interpret')->middleware('throttle');

    /**
     * Webdomain: /api/v1/{any}
     *
     * @author Christopher M.
     * @package POST
     * @category v1ApiRoutes
     * @access Api Token
     * @version 1.0.0
     */

    Route::post('/{endpoint}', 'ApiEndpointController@interpret')->middleware('throttle');
});
