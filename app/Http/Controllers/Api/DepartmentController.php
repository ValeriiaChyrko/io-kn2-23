<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentCreateRequest;
use App\Http\Requests\Department\DepartmentDeleteRequest;
use App\Http\Requests\Department\DepartmentUpdateRequest;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Support\Collection;

class DepartmentController extends Controller
{
    /**
     * @var DepartmentRepository
     */
    private DepartmentRepository $departmentRepository;

    public function __construct()
    {
        $this->departmentRepository = app(DepartmentRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->departmentRepository->getAllWithParents();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentCreateRequest $request
     * @return Department
     */
    public function store(DepartmentCreateRequest $request): Department
    {
        return Department::create($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DepartmentUpdateRequest $request
     * @param Department $department
     */
    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        $department->update($request->validated());
    }

    public function destroyMany(DepartmentDeleteRequest $request)    //TODO: Create simple destroy method and observer
    {
        $idList = $request->input('idList');

        Department::destroy($idList);
    }

}
