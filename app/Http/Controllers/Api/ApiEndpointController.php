<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Http\Resources\ApiError;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api;
use Illuminate\Support\Facades\Auth;

class ApiEndpointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Determines what endpoint is being accessed
     *
     * @param Request $request
     * @param string $endpoint
     * @return JsonResponse
     */
    public function interpret(Request $request, $endpoint)
    {

        if (Optional(User::where('api_token', hash('sha256', $request->bearerToken()))->first())->name) {
            switch ($endpoint) {
                case 'info':
                    return (new Api([
                        'totalActivity' => Activity::count(),
                        'totalUsers' => User::count()
                    ]))->response()->setStatusCode(200);
                    break;
                default:
                    return (new ApiError([
                        'message' => 'Unknown endpoint provided.'
                    ]))->response()->setStatusCode(404);
            }
        } else {
            return (new ApiError([
                'message' => 'Invalid Api token provided.'
            ]))->response()->setStatusCode(401);
        }
    }

    /**
     * Get the bearer token from the request headers.
     *
     * @return string|null
     */
    public function bearerToken()
    {
        $header = $this->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }
}
