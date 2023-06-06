<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HardwareModel\HardwareModelCreateRequest;
use App\Http\Requests\HardwareModel\HardwareModelDeleteRequest;
use App\Http\Requests\HardwareModel\HardwareModelUpdateRequest;
use App\Models\HardwareModel;
use App\Repositories\HardwareModelRepository;
use Illuminate\Support\Collection;

class HardwareModelController extends Controller
{
    /**
     * @var HardwareModelRepository
     */
    private $hardwareModelRepository;

    public function __construct()
    {
        $this->hardwareModelRepository = app(HardwareModelRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->hardwareModelRepository->getAllWithPaginateAndFiltering();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HardwareModelCreateRequest $request
     * @return HardwareModel
     */
    public function store(HardwareModelCreateRequest $request): HardwareModel
    {
        return HardwareModel::create($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HardwareModelUpdateRequest $request
     * @param HardwareModel $hardware_model
     */
    public function update(HardwareModelUpdateRequest $request, HardwareModel $hardware_model)
    {
        $hardware_model->update($request->validated());
    }

    public function destroyMany(HardwareModelDeleteRequest $request)
    {
        $idList = $request->input('idList');
        HardwareModel::destroy($idList);
    }
}
