<?php

namespace App\Http\Requests\License;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class LicenseCopyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Invoice $invoice */
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
            'count' => 'required|numeric'
        ];
    }
}
