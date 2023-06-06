<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\CompletedRepairUpdateRequest;
use App\Http\Requests\Repair\RepairCompleteRequest;
use App\Http\Requests\Repair\RepairCreateRequest;
use App\Http\Requests\Repair\RepairUpdateRequest;
use App\Models\Repair;
use App\Models\Status;
use App\Repositories\RepairRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class RepairController extends Controller
{
    /**
     * @var RepairRepository
     */
    private $repairRepository;

    public function __construct()
    {
        $this->repairRepository = app(RepairRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->repairRepository->getAllWithRelationsAndPaginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RepairCreateRequest $request
     * @return Repair
     */
    public function store(RepairCreateRequest $request): Repair
    {
        return Repair::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $id
     * @return Repair|null
     */
    public function show($id): ?Repair
    {
        $repair = $this->repairRepository->getForShow($id);
        abort_if(empty($repair), Response::HTTP_NOT_FOUND);

        return $repair;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RepairUpdateRequest $request
     * @param Repair $repair
     * @return Repair
     */
    public function update(RepairUpdateRequest $request, Repair $repair): Repair
    {
        $repair->update($request->validated());

        return $repair;
    }

    /**
     * Update completed repair end_date and is_unrepairable fields.
     *
     * @param CompletedRepairUpdateRequest $request
     * @param Repair $repair
     * @return Repair
     */
    public function updateCompleted(CompletedRepairUpdateRequest $request, Repair $repair): Repair
    {
        $repair->update($request->validated());

        $item = $repair->item;
        $item->status_id = ($repair->is_unrepairable
            ? Status::STATUS_UNREPAIRABLE
            : Status::STATUS_IN_USE
        );
        $item->save();

        return $repair;
    }

    /**
     * Updates specified repair, sets it as completed and updates the item state.
     *
     * @param RepairCompleteRequest $request
     * @param Repair $repair
     * @return Repair
     */
    public function complete(RepairCompleteRequest $request, Repair $repair): Repair
    {
        $repair->update($request->validated());

        $item = $repair->item;

        $item->status_id = ($repair->is_unrepairable
            ? Status::STATUS_UNREPAIRABLE
            : Status::STATUS_IN_USE
        );
        $item->save();

        return $repair;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Repair $repair
     * @return JsonResponse
     */
    public function destroy(Repair $repair): JsonResponse
    {
        $isDeleted = $repair->delete();
        if(! $isDeleted) {
            return response()->json([
                'message' => 'Repair cannot be deleted.'
            ], Response::HTTP_CONFLICT);
        }

        return response()->json();    //Return 200 (HTTP OK)
    }
}
