<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Users\CreateUserAction;
use App\DataTransferObjects\StoreUserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\HtmlString;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected CreateUserAction $createUserAction,
    ) {
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->createUserAction->execute(StoreUserData::fromRequest($request));
        $response = "<p>Successful Sign Up</p><p>We've sent a verification email to: {$user->email}</p>";

        return response()->json(['message' => clean(new HtmlString($response))]);
    }
}
