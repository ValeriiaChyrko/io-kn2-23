<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    public function __construct()
    {
        $this->roleRepository = app(RoleRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->roleRepository->paginate();
    }

    /**
     * Display the specified item.
     *
     * @param mixed $id
     * @return Role
     */
    public function show($id): Role
    {
        $role = $this->roleRepository->find($id);
        abort_if(empty($role), 404);

        return $role;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Role
     */
    public function store(Request $request): Role
    {
//        return Role::create($request->validated());
        abort(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @return Role|Model
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $data = $request->validated();
        $role->permissions()->sync($data['permissions']);

        return $role;
    }
}
