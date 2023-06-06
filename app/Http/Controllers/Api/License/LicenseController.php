<?php

namespace App\Http\Controllers\Api\License;

use App\Http\Controllers\Controller;
use App\Http\Requests\License\LicenseUpdateRequest;
use App\Models\License;
use App\Repositories\LicenseRepository;
use Illuminate\Support\Collection;

class LicenseController extends Controller
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
     * Display a listing of the items.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->licenseRepository->getAllWithRelationsAndPaginate();
    }

    /**
     * Update the specified license in storage.
     *
     * @param LicenseUpdateRequest $request
     * @param License $license
     * @return License
     */
    public function update(LicenseUpdateRequest $request, License $license): License
    {
        $license->update($request->validated());

        return $license;
    }

    /**
     * Remove the specified license from storage.
     *
     * @param License $license
     * @return bool|null
     */
    public function destroy(License $license): ?bool
    {
        return $license->delete();
    }
}
