<?php

namespace App\Http\Requests\Invoice;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest
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
            'date' => 'required|date',
            'number' => 'required|string|max:100',
            'receiver_id' => 'required|integer|exists:users,id',
            'provider_id' => 'required|integer|exists:providers,id'
        ];
    }
}
