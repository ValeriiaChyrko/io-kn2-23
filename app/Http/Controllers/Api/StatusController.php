<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Status\StatusCreateRequest;
use App\Http\Requests\Status\StatusDeleteRequest;
use App\Http\Requests\Status\StatusUpdateRequest;
use App\Models\Status;
use App\Repositories\StatusRepository;
use Illuminate\Support\Collection;

class StatusController extends Controller
{
    /**
     * @var StatusRepository
     */
    private $statusRepository;

    public function __construct()
    {
        $this->statusRepository = app(StatusRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->statusRepository->getAllWithPaginateAndFiltering();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StatusUpdateRequest $request
     * @param Status $status
     */
    public function update(StatusUpdateRequest $request, Status $status)
    {
        $status->update($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StatusCreateRequest $request
     * @return Status
     */
    public function store(StatusCreateRequest $request): Status
    {
        return Status::create($request->validated());
    }

    public function destroyMany(StatusDeleteRequest $request)
    {
        $idList = $request->input('idList');
        Status::destroy($idList);

    }

}
