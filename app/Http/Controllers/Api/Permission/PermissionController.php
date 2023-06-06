<?php

namespace App\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Collection;

class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    private PermissionRepository $permissionRepository;

    public function __construct()
    {
        $this->permissionRepository = app(PermissionRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->permissionRepository->paginate();
    }
}
