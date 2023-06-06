<?php

namespace App\Http\Requests\Repair;

use App\Models\Repair;
use App\Rules\RepairStartDateBeforeOrEqualEndDate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Repair $repair
 */
class RepairUpdateRequest extends FormRequest
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
            'start_date' => ['required', 'date', new RepairStartDateBeforeOrEqualEndDate($this->repair)],
            'user_id' => 'required|exists:users,id',
            'provider_id' => 'required:exists:providers,id',
            'comment' => 'nullable|string'
        ];
    }
}
