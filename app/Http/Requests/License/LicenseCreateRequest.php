<?php

namespace App\Http\Requests\License;

use App\Models\Invoice;
use App\Rules\ItemParentable;
use Illuminate\Foundation\Http\FormRequest;

class LicenseCreateRequest extends FormRequest
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
            'software_model_id' => 'required|exists:software_models,id',
            'price' => 'required|numeric|max:999999.99',
            'owner_id' => 'required|exists:users,id',
            'end_date' => 'nullable|date',
            'item_id' => ['nullable', 'exists:items,id', new ItemParentable()]
        ];
    }
}
