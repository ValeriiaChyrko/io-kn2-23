<?php

namespace App\Rules;

use App\Models\Item;
use Illuminate\Contracts\Validation\Rule;

class ItemParentable implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  Item|int  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if($value instanceof Item) {
            $item = $value;
        }
        else {
            $item = Item::find($value);
            if(empty($item)) {
                return false;
            }
        }

        return is_null($item->part_of);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'This item is a part of another one. Item can\'t have any parts or licenses.';
    }
}
