<?php

namespace App\Http\Requests\Item;

use App\Models\Invoice;
use App\Rules\ItemParentable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Invoice $invoice */
        $invoice = $this->route('invoice');
        if($invoice->approved and !can('edit-approved-invoice')) {
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
                'nullable',
                'regex:/^\d+(?:[-\/]\d+)*$/',
                Rule::unique('items', 'inventory_number')
            ],
            'type_id' => 'required|exists:types,id',
            'owner_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'hardware_model_id' => 'required|exists:hardware_models,id',
            'price' => 'required|numeric|max:999999.99',
            'part_of' => ['nullable', 'exists:items,id', new ItemParentable()]
        ];
    }
}
