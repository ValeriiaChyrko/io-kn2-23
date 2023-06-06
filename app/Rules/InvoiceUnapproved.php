<?php

namespace App\Rules;

use App\Models\Invoice;
use Illuminate\Contracts\Validation\Rule;

class InvoiceUnapproved implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  Invoice $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !$value->approved;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'This invoice is already approved.';
    }
}
