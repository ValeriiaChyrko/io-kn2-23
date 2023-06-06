<?php

namespace App\Rules;

use App\Models\Repair;
use Illuminate\Contracts\Validation\Rule;

class RepairCompleted implements Rule
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
        return $value->is_completed;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'This repair is uncompleted.';
    }
}
