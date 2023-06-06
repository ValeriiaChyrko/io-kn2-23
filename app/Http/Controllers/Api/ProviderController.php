<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\ProviderCreateRequest;
use App\Http\Requests\Provider\ProviderDeleteRequest;
use App\Http\Requests\Provider\ProviderUpdateRequest;
use App\Models\Provider;
use App\Repositories\ProviderRepository;
use Illuminate\Support\Collection;

class ProviderController extends Controller
{
    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    public function __construct()
    {
        $this->providerRepository = app(ProviderRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->providerRepository->getAllWithPaginateAndFiltering();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProviderUpdateRequest $request
     * @param Provider $provider
     */
    public function update(ProviderUpdateRequest $request, Provider $provider)
    {
        $provider->update($request->validated());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProviderCreateRequest $request
     * @return Provider
     */
    public function store(ProviderCreateRequest $request): Provider
    {
        return Provider::create($request->validated());
    }

    public function destroyMany(ProviderDeleteRequest $request)
    {
        $idList = $request->input('idList');
        Provider::destroy($idList);

    }

}
