<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): UserResource
    {
        $request->authenticate();

        if (! $request->user()->hasVerifiedEmail()) {
            response()->json(['status' => 'Email not verified.']);
        }

        /** @var User $user */
        $user = $request->user();
        $token = $user->createToken('authToken')->plainTextToken;
        $user->update(['last_login' => Carbon::now()]);
        $user->token = $token;

        return new UserResource($user);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        // $request->user()->currentAccessToken()->delete();

        /** @var User $user */
        $user = Auth::user();
        $tokenId = Str::before(request()->bearerToken(), '|');
        $user->tokens()->where('id', $tokenId)->delete();

        return response()->json(['message' => 'Logged out.']);
    }

    public function me(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
