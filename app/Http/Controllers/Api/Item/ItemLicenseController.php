<?php

namespace App\Http\Controllers\Api\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemLicenseCreateRequest;
use App\Models\Item;
use App\Models\License;
use App\Repositories\LicenseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ItemLicenseController extends Controller
{
    /**
     * @var LicenseRepository
     */
    private $licenseRepository;

    public function __construct()
    {
        $this->licenseRepository = app(LicenseRepository::class);
    }

    /**
     * Display a listing of the licenses that belongs to specified item.
     *
     * @param Item $item
     * @return Collection
     */
    public function index(Item $item): Collection
    {
        return $this->licenseRepository->getByItemId($item->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ItemLicenseCreateRequest $request
     * @param Item $item
     * @return License|Model
     */
    public function store(ItemLicenseCreateRequest $request, Item $item)
    {
        $license = $request->validated();
        $license['invoice_id'] = $item->invoice_id;
        $license['owner_id'] = $item->owner_id;

        return $item->licenses()->create($license);
    }
}
