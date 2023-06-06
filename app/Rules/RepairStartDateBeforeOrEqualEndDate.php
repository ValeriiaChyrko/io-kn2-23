<?php

namespace App\Rules;

use App\Models\Repair;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class RepairStartDateBeforeOrEqualEndDate implements Rule
{
    /**
     * Repair to check.
     *
     * @var Repair
     */
    private Repair $repair;

    /**
     * Create a new rule instance.
     *
     * @param Repair $repair
     */
    public function __construct(Repair $repair)
    {
        $this->repair = $repair;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value Repair end date to validate
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if(empty($this->repair->end_date)) {
            return true;
        }

        //Returns true if the start_date($value) is less than start_date or equal
        return (new Carbon($value))->lte($this->repair->end_date);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Repair start date must be less or equal to the end date.';
    }
}
