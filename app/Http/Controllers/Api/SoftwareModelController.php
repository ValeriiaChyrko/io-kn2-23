<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SoftwareModel\SoftwareModelCreateRequest;
use App\Http\Requests\SoftwareModel\SoftwareModelDeleteRequest;
use App\Http\Requests\SoftwareModel\SoftwareModelUpdateRequest;
use App\Models\SoftwareModel;
use App\Repositories\SoftwareModelRepository;
use Illuminate\Support\Collection;

class SoftwareModelController extends Controller
{
    /**
     * @var SoftwareModelRepository
     */
    private $softwareModelRepository;

    public function __construct()
    {
        $this->softwareModelRepository = app(SoftwareModelRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->softwareModelRepository->getAllWithPaginateAndFiltering();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SoftwareModelCreateRequest $request
     * @return SoftwareModel
     */
    public function store(SoftwareModelCreateRequest $request): SoftwareModel
    {
        return SoftwareModel::create($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SoftwareModelUpdateRequest  $request
     * @param SoftwareModel $software_model
     */
    public function update(SoftwareModelUpdateRequest $request, SoftwareModel $software_model)
    {
        $software_model->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SoftwareModelDeleteRequest $request
     */
    public function destroyMany(SoftwareModelDeleteRequest $request)
    {
        $idList = $request->input('idList');
        SoftwareModel::destroy($idList);
    }
}
