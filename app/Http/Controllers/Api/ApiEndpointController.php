<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Discipline;
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
     * Determines what endpoint is being accessed
     *
     * @param Request $request
     * @param string $endpoint
     * @param null $argument
     * @param null $argument2
     * @return JsonResponse
     */
    public function interpret(Request $request, $endpoint, $argument = null, $argument2 = null)
    {
        $authUser = User::where('api_token', hash('sha256', $request->bearerToken()))->first();

        if ($authUser) {
            $authLevel = $authUser->getRoles()->first()->level;

            switch ($endpoint) {
                // Generic Info Response - Probs remove for prod
                case 'info':
                    return (new Api([
                        'totalActivity' => Activity::count(),
                        'totalUsers' => User::count()
                    ]))->response()->setStatusCode(200);
                    break;

                // Pull a specific user's data - SIT+
                case 'users':
                    if ($authLevel >= 4) {
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

                // Pull a specific patrol log - SIT+
                case 'patrols':
                    if ($authLevel >= 4) {
                        if (!is_null($argument) && is_numeric($argument)) {
                            $ourPAL = Activity::find($argument);

                            if (!is_null($ourPAL)) {
                                return (new Api($ourPAL))->response()->setStatusCode(200);
                            } else {
                                return (new ApiError([
                                    'message' => 'No patrol log with that ID could be found.'
                                ]))->response()->setStatusCode(404);
                            }
                        } else {
                            return (new ApiError([
                                'message' => 'Not enough arguments provided, or, provided arguments are invalid.'
                            ]))->response()->setStatusCode(400);
                        }
                    } else {
                        return (new ApiError([
                            'message' => 'You do not have access to this endpoint.'
                        ]))->response()->setStatusCode(403);
                    }
                    break;

                // Patrols by a specific person - SIT+
                case 'userpatrols':
                    if ($authLevel >= 4) {
                        if (!is_null($argument) && is_numeric($argument)){
                            if (is_null($argument2) || !is_numeric($argument2)) {
                                $argument2 = 50;
                            }
                            if ($argument2 > 0 && $argument2 <= 50) {
                                $ourPALs = Activity::where('user_id', $argument)->limit($argument2);

                                return (new Api($ourPALs->get()))->response()->setStatusCode(200);
                            } else {
                                return (new ApiError([
                                    'message' => 'The second argument must be more than 0, and less than 51.'
                                ]))->response()->setStatusCode(400);
                            }
                        } else {
                            return (new ApiError([
                                'message' => 'Not enough arguments provided, or, provided arguments are invalid.'
                            ]))->response()->setStatusCode(400);
                        }
                    }   else {
                        return (new ApiError([
                            'message' => 'You do not have access to this endpoint.'
                        ]))->response()->setStatusCode(403);
                    }
                    break;

                // Pull a specific DA - SIT+
                case 'disciplines':
                    if ($authLevel >= 4) {
                        if (!is_null($argument) && is_numeric($argument)) {
                            $ourDA = Discipline::find($argument);

                            if (!is_null($ourDA)) {
                                return (new Api($ourDA))->response()->setStatusCode(200);
                            } else {
                                return (new ApiError([
                                    'message' => 'No DA with that ID could be found.'
                                ]))->response()->setStatusCode(404);
                            }
                        } else {
                            return (new ApiError([
                                'message' => 'Not enough arguments provided, or, provided arguments are invalid.'
                            ]))->response()->setStatusCode(400);
                        }
                    } else {
                        return (new ApiError([
                            'message' => 'You do not have access to this endpoint.'
                        ]))->response()->setStatusCode(403);
                    }
                    break;

                // DAs for a specific person - SIT+
                case 'userdisciplines':
                    if ($authLevel >= 4) {
                        if (!is_null($argument) && is_numeric($argument)){
                            if (is_null($argument2) || !is_numeric($argument2)) {
                                $argument2 = 50;
                            }

                            if ($argument2 > 0 && $argument2 <= 50) {
                                $ourDAs = Discipline::where('user_id', $argument)->limit($argument2);

                                return (new Api($ourDAs->get()))->response()->setStatusCode(200);
                            } else {
                                return (new ApiError([
                                    'message' => 'The second argument must be more than 0, and less than 51.'
                                ]))->response()->setStatusCode(400);
                            }
                        } else {
                            return (new ApiError([
                                'message' => 'Not enough arguments provided, or, provided arguments are invalid.'
                            ]))->response()->setStatusCode(400);
                        }
                    }   else {
                        return (new ApiError([
                            'message' => 'You do not have access to this endpoint.'
                        ]))->response()->setStatusCode(403);
                    }
                    break;

                // DAs issued by a specific person - SIT+
                case 'userissueddisciplines':
                    if ($authLevel >= 4) {
                        if (!is_null($argument) && is_numeric($argument)){
                            if (is_null($argument2) || !is_numeric($argument2)) {
                                $argument2 = 50;
                            }

                            if ($argument2 > 0 && $argument2 <= 50) {
                                $ourDAs = Discipline::where('issued_by', $argument)->limit($argument2);

                                return (new Api($ourDAs->get()))->response()->setStatusCode(200);
                            } else {
                                return (new ApiError([
                                    'message' => 'The second argument must be more than 0, and less than 51.'
                                ]))->response()->setStatusCode(400);
                            }
                        } else {
                            return (new ApiError([
                                'message' => 'Not enough arguments provided, or, provided arguments are invalid.'
                            ]))->response()->setStatusCode(400);
                        }
                    }   else {
                        return (new ApiError([
                            'message' => 'You do not have access to this endpoint.'
                        ]))->response()->setStatusCode(403);
                    }
                    break;

                // Invalid endpoint
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
