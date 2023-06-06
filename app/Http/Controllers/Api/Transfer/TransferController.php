<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\TransferCompleteRequest;
use App\Http\Requests\Transfer\TransferCreateRequest;
use App\Models\Item;
use App\Models\Status;
use App\Models\Transfer;
use App\Repositories\TransferRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * @var TransferRepository
     */
    private $transferRepository;

    public function __construct()
    {
        $this->transferRepository = app(TransferRepository::class);

    }

    /**
     * Display a listing of the transfers.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->transferRepository->getAllWithRelationsAndPaginate();
    }

    /**
     * Display the specified resource.
     *
     * @param Transfer $transfer
     * @return Transfer
     */
    public function show(Transfer $transfer): Transfer
    {
        return $transfer;    // TODO: Load joined fields (e.g. provider_title)
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransferCompleteRequest $request
     * @param Transfer $transfer
     * @return Transfer
     */
    public function confirm(TransferCompleteRequest $request, Transfer $transfer): Transfer
    {
        return DB::transaction(function() use ($request, $transfer) {
            $transfer->update($request->validated());
            $items = $transfer->items;

            foreach ($items as $item) {
                if ($request->validated()["confirmed"]) {
                    $item->owner_id = $transfer->to_user_id;
                }
                $item->status_id = Status::STATUS_IN_USE;

                $item->save();
            }
            return $transfer;
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransferCreateRequest $request
     * @return Transfer
     */
    public function store(TransferCreateRequest $request): Transfer
    {
        return DB::transaction(function() use ($request) {
            $data = $request->validated();

            $fileUrl = $request->file('file')->store('transfer', 'private');

            $items = Item::find($data['items_id']);

            foreach ($items as $item) {
                $item->update(['status_id' => Status::STATUS_TRANSFERRING]);
            }

            $data['from_user_id'] = $items->first()->owner_id;
            $data['file_url'] = $fileUrl;

            $transfer = Transfer::create($data);
            $transfer->items()->attach($data['items_id']);

            return $transfer;
        });
    }
    /* TODO: передача айтемів без номерів, валідація статусу передачі на сервері, вивід предметів в передачах, підсвітка отримувача, генерація файла накладної, підписання ЕЦП*/

    /**
     * Remove the specified resource from storage.
     *
     * @param Transfer $transfer
     * @return boolean|null
     */
    public function destroy(Transfer $transfer): ?bool
    {
        return DB::transaction(function () use ($transfer) {
            foreach ($transfer->items as $item) {
                $item->update(['status_id' => Status::STATUS_IN_USE]);
            }
            return $transfer->delete();
        });
    }

}
