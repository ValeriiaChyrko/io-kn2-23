<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceCreateRequest extends FormRequest
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
            'file' => 'file|mimes:pdf,jpg,jpeg,png',
            'date' => 'required|date',
            'number' => 'required|string|max:100',
            'receiver_id' => 'required|integer|exists:users,id',
            'provider_id' => 'required|integer|exists:providers,id'
        ];
    }
}
