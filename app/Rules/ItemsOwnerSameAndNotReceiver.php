<?php

namespace App\Rules;

use App\Models\Item;
use Illuminate\Contracts\Validation\Rule;

class ItemsOwnerSameAndNotReceiver implements Rule
{
    private $receiverId;

    public function __construct($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    /**
     * Determine if the validation rule passes.
     * Check if items owner is the same
     *
     * @param  string  $attribute
     * @param  Item  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $owners = Item::find($value)->pluck('owner_id');

        return $this->receiverId != $owners->first() && $owners->unique()->count() === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'This transfer items has different owners or receiver is the same as items owner.';
    }
}
