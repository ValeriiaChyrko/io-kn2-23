<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Type\TypeCreateRequest;
use App\Http\Requests\Type\TypeDeleteRequest;
use App\Http\Requests\Type\TypeUpdateRequest;
use App\Models\Type;
use App\Repositories\TypeRepository;
use Illuminate\Support\Collection;

class TypeController extends Controller
{
    /**
     * @var TypeRepository
     */
    private $typeRepository;

    public function __construct()
    {
        $this->typeRepository = app(TypeRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->typeRepository->getAllWithPaginateAndFiltering();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TypeCreateRequest $request
     * @return Type
     */
    public function store(TypeCreateRequest $request): Type
    {
        return Type::create($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TypeUpdateRequest $request
     * @param Type $type
     */
    public function update(TypeUpdateRequest $request, Type $type)
    {
        $type->update($request->validated());
    }

    public function destroyMany(TypeDeleteRequest $request)
    {
        $idList = $request->input('idList');
        Type::destroy($idList);
    }
}
