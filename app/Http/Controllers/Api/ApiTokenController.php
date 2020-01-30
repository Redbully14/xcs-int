<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Resources\Api;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Http\Resources\ApiError;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ApiTokenController extends Controller
{
    /**
     * Create a new Api Token for an existing account.
     *
     * @return JsonResponse
     */

    // This runs off the web.php route so that it can make use of auth-ed user accounts
    protected function gimme()
    {
        if (Auth::check()) {
            $token = Str::random(60);

            User::find(auth()->user()->id)->forceFill(['api_token' => hash('sha256', $token),])->save();

            return (new Api([
                'api_token' => $token
            ]))->response()->setStatusCode(201);
        } else {
            return (new ApiError([
                'status' => 'failed',
                'message' => 'You need to be logged in to preform this action!'
            ]))->response()->setStatusCode(401);
        }
    }
}
