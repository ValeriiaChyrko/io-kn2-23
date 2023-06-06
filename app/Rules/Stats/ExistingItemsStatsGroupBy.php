<?php

namespace App\Rules\Stats;

use App\Stats\ItemStats;
use Illuminate\Contracts\Validation\Rule;

class ExistingItemsStatsGroupBy implements Rule
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
        return in_array($value, ItemStats::getAvailableGroupBy());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $availableGroupBy = implode(', ', ItemStats::getAvailableGroupBy());

        return sprintf('Wrong group_by. Available keys: %s.', $availableGroupBy);
    }
}
