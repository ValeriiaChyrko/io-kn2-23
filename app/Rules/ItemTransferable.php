<?php

namespace App\Rules;

use App\Models\Item;
use Illuminate\Contracts\Validation\Rule;

class ItemTransferable implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $item = Item::find($value);
        if(empty($item)) {
            return false;
        }

        return $item->is_transferable;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Item can\'t be sent for repair.';
    }
}
