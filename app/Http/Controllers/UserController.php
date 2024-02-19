<?php

namespace App\Http\Controllers;

use App\Actions\CreateUserAction;
use App\Actions\UpdateUserAction;
use App\DataTransferObjects\StoreUserData;
use App\DataTransferObjects\UpdateUserData;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected CreateUserAction $createUserAction,
        protected UpdateUserAction $updateUserAction
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): UserCollection
    {
        $this->authorize('viewAny', User::class);
        $users = User::query()
            ->userType($request->get('type'))
            ->search($request->get('q'))
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $user = $this->createUserAction->execute(StoreUserData::fromRequest($request));

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $this->updateUserAction->execute(UpdateUserData::fromRequest($request), $user);

        return new UserResource($user->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        $user->delete();

        return response()->json(['message' => 'User deleted.']);
    }
}
