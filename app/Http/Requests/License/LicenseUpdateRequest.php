<?php

namespace App\Http\Requests\License;

use App\Models\License;
use App\Rules\ItemParentable;
use Illuminate\Foundation\Http\FormRequest;

class LicenseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var License $license */
        $license = $this->route('license');
        if($license->invoice->approved and !can('edit-approved-invoice')) {
            return false;
        }

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
            'software_model_id' => 'sometimes|exists:software_models,id',
            'price' => 'sometimes|nullable|numeric|max:999999.99',
            'owner_id' => 'sometimes|exists:users,id',
            'end_date' => 'sometimes|nullable|date',
            'item_id' => ['sometimes', 'nullable', 'exists:items,id', new ItemParentable()]
        ];
    }
}
