<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\License\LicenseCreateRequest;
use App\Models\License;
use App\Models\Transfer;
use App\Repositories\LicenseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TransferLicenseController extends Controller
{
    /**
     * @var LicenseRepository
     */
    private LicenseRepository $licenseRepository;

    public function __construct()
    {
        $this->licenseRepository = app(LicenseRepository::class);
    }

    /**
     * Display a listing of the items that belongs to specified transfer.
     *
     * @param mixed $transferId
     * @return Collection
     */
    public function index($transferId): Collection
    {
        return $this->licenseRepository->getByTransferId($transferId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LicenseCreateRequest $request
     * @param Transfer $transfer
     * @return License|Model
     */
    public function store(LicenseCreateRequest $request, Transfer $transfer)
    {
        return $transfer->licenses()->create($request->validated());
    }
}
