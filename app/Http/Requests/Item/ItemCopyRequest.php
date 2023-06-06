<?php

namespace App\Http\Requests\Item;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class ItemCopyRequest extends FormRequest
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
            'useRange' => 'required|boolean',
            'numbersRange' => 'required_if:useRange,true|array',
            'numbersRange.*' => 'unique:items,inventory_number',
            'count' => 'required_if:useRange,false|numeric'
        ];
    }
}
