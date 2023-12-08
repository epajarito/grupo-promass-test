<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthenticateRequest;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\JsonResponse;

class AuthenticateController extends Controller
{
    /**
     * Handle the incoming request for authenticate.
     *
     * @param AuthenticateRequest  $request
     * @return UserResource|JsonResponse
    */
    public function __invoke(AuthenticateRequest $request): UserResource|JsonResponse
    {
        $credentials = $request->only('telephone', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['The provided credentials are incorrect.']
                ]
            ], 422);
        }
        $user = auth()->user();
        $user->setLastLogin();

        return new UserResource($user);
    }
}
