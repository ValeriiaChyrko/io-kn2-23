<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\GoogleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->userRepository->getAllWithPaginateAndFiltering();
    }

    /**
     * Get authenticated user.
     *
     * @param Request $request
     * @return User|null
     */
    public function current(Request $request)
    {
        return auth()->user()->append('permissions');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     * @return User
     */
    public function store(UserCreateRequest $request): User
    {
        return User::create($request->validated());
    }

    public function destroyMany(UserDeleteRequest $request)
    {
        $idList = $request->input('idList');
        User::destroy($idList);

    }
    public function addGoogleUsers()
    {
        $addGoogleUsers = new GoogleClient;
        return $addGoogleUsers->addUsers();
    }

}
