<?php

namespace App\Http\Requests\Repair;

use App\Rules\ItemRepairable;
use Illuminate\Foundation\Http\FormRequest;

class RepairCreateRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'item_id' => ['required', 'exists:items,id', new ItemRepairable()],
            'user_id' => 'required|exists:users,id',
            'provider_id' => 'required|exists:providers,id'
        ];
    }
}
