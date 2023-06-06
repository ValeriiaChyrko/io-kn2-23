<?php

namespace App\Http\Requests\Invoice;

use App\Rules\InvoiceUnapproved;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceApproveRequest extends FormRequest
{
    /**
     * Get all the input and files for the request.
     *
     * @param array|mixed|null $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $data = parent::all($keys);

        $data['invoice'] = $this->route('invoice');

        return $data;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return can('approve-invoice');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'invoice' => [new InvoiceUnapproved()]
        ];
    }
}
