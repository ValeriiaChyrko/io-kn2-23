<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ItemRepository;
use Illuminate\Support\Collection;

class UserItemController extends Controller
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    public function __construct()
    {
        $this->itemRepository = app(ItemRepository::class);
    }

    /**
     * Display a listing of the items that belongs to specified user.
     *
     * @param User $user
     * @return Collection
     */
    public function index(User $user): Collection
    {
        return $this->itemRepository->getAllUserItemsWithRelationsAndPaginate($user->id);
    }
}
