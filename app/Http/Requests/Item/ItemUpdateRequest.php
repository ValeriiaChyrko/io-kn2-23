<?php

namespace App\Http\Requests\Item;

use App\Models\Item;
use App\Rules\ItemParentable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Item $item */
        $item = $this->route('item');
        if($item->invoice->approved and !can('edit-approved-invoice')) {
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
            'inventory_number' => [
                'sometimes',
                'nullable',
                'regex:/^\d+(?:[-\/]\d+)*$/',
                Rule::unique('items', 'inventory_number')->ignore($this->id),
            ],
            'type_id' => 'sometimes|exists:types,id',
            'owner_id' => 'sometimes|exists:users,id',
            'department_id' => 'sometimes|exists:departments,id',
            'hardware_model_id' => 'sometimes|exists:hardware_models,id',
            'price' => 'sometimes|nullable|numeric|max:999999.99',   // TODO: Nullable price ONLY for parts
            'part_of' => ['sometimes', 'nullable', 'exists:items,id', new ItemParentable()]
        ];
    }
}
