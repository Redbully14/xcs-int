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
     * @param null $argument
     * @return JsonResponse
     */
    public function interpret(Request $request, $endpoint, $argument = null)
    {
        $authUser = User::where('api_token', hash('sha256', $request->bearerToken()))->first();

        if ($authUser) {
            $authLevel = $authUser->getRoles()->first()->level;

            switch ($endpoint) {
                case 'info':
                    return (new Api([
                        'totalActivity' => Activity::count(),
                        'totalUsers' => User::count()
                    ]))->response()->setStatusCode(200);
                    break;
                case 'users':
                    if ($authLevel === 8) {
                        if (!is_null($argument) && is_numeric($argument)) {
                            $ourUser = User::find($argument);

                            if (!is_null($ourUser)) {
                                return (new Api($ourUser))->response()->setStatusCode(200);
                            } else {
                                return (new ApiError([
                                    'message' => 'No user with that ID could be found.'
                                ]))->response()->setStatusCode(404);
                            }
                        } else {
                            return (new ApiError([
                                'message' => 'Not enough arguments provided, or, provided argument is invalid.'
                            ]))->response()->setStatusCode(400);
                        }
                    } else {
                        return (new ApiError([
                            'message' => 'You do not have access to this endpoint.'
                        ]))->response()->setStatusCode(403);
                    }
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
