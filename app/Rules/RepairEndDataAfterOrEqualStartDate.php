<?php

namespace App\Rules;

use App\Models\Repair;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class RepairEndDataAfterOrEqualStartDate implements Rule
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
        //Returns true if the end_date($value) is greater than start_date or equal
        return (new Carbon($value))->gte($this->repair->start_date);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Repair end date must be greater or equal to the start date.';
    }
}
