<?php

namespace App\Http\Controllers;

use App\Actions\Users\CreateUserAction;
use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\UpdateUserAction;
use App\Actions\Users\UpdateUserPasswordAction;
use App\DataTransferObjects\StoreUserData;
use App\DataTransferObjects\UpdateUserData;
use App\DataTransferObjects\UpdateUserPasswordData;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\DropdownResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected CreateUserAction $createUserAction,
        protected UpdateUserAction $updateUserAction,
        protected DeleteUserAction $deleteUserAction,
        protected UpdateUserPasswordAction $updateUserPasswordAction,
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
        $this->deleteUserAction->execute($user);

        return response()->json(['message' => 'User deleted.']);
    }

    /**
     * Update the specified users password.
     */
    public function updatePassword(UpdateUserPasswordRequest $request, User $user): UserResource|JsonResponse
    {
        $res = $this->updateUserPasswordAction->execute(UpdateUserPasswordData::fromRequest($request), $user);

        return $res instanceof User
            ? new UserResource($user)
            : response()->json(['message' => $res])->setStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Display users as dropdowns.
     */
    public function getDropdown(): AnonymousResourceCollection
    {
        return DropdownResource::collection(User::get());
    }
}
