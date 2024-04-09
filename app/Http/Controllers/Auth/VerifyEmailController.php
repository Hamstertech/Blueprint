<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FrontendService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): UserResource
    {
        $user = User::find($request->validated('id'));

        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified.',
                'url' => (new FrontendService)->login(),
            ]);
        }

        if (! hash_equals((string) $request->validated('token'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $user->update([
            'password' => Hash::make($request->validated('password')),
            'last_login' => Carbon::now(),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;
        $user->token = $token;

        return new UserResource($user);
    }
}
