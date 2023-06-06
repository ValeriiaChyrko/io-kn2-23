<?php

namespace App\Http\Requests\Repair;

use App\Models\Repair;
use App\Rules\RepairCompleted;
use App\Rules\RepairEndDataAfterOrEqualStartDate;
use App\Rules\RepairItemStatusAllowsUpdate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Repair repair
 */
class CompletedRepairUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param array|mixed|null $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $data = parent::all($keys);

        $data['repair'] = $this->route('repair');

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'repair' => [new RepairCompleted(), new RepairItemStatusAllowsUpdate()],
            'end_date' => ['required', 'date', new RepairEndDataAfterOrEqualStartDate($this->repair)],
            'is_unrepairable' => 'required|boolean',
            'comment' => 'nullable|string'
        ];
    }
}
