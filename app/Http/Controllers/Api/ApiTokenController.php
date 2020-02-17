<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Resources\Api;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Resources\ApiError;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ApiTokenController extends Controller
{
    /**
     * Create a new Api Token for an existing account.
     *
     * @param request $request
     * @return JsonResponse
     */

    // This runs off the web.php route so that it can make use of auth-ed user accounts
    protected function gimme(request $request)
    {
        if (Auth::check()) {
            $token = Str::random(60);

            User::find(auth()->user()->id)->forceFill(['api_token' => hash('sha256', $token),])->save();

            return (new Api([
                'api_token' => $token
            ]))->response()->setStatusCode(201);
        } else {
            Log::critical('User with IP of ' . $request->ip() . ' attempted to request an Api token, but was not logged in.');
            return (new ApiError([
                'status' => 'failed',
                'message' => 'You need to be logged in to preform this action!'
            ]))->response()->setStatusCode(401);
        }
    }
}
