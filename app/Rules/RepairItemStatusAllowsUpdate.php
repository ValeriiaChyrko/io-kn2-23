<?php

namespace App\Rules;

use App\Models\Repair;
use Illuminate\Contracts\Validation\Rule;

class RepairItemStatusAllowsUpdate implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  Repair  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $value->is_completion_data_editable;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Related item status is not IN_USE or UNREPAIRABLE.';
    }
}
