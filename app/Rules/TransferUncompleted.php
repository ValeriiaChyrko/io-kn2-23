<?php

namespace App\Rules;

use App\Models\Transfer;
use Illuminate\Contracts\Validation\Rule;

class TransferUncompleted implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  Transfer  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return is_null($value->confirmed);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'This transfer is already closed.';
    }
}
