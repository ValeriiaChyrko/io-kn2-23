<?php

namespace App\Http\Requests\Transfer;

use App\Rules\ItemsOwnerSameAndNotReceiver;
use Illuminate\Foundation\Http\FormRequest;

class TransferCreateRequest extends FormRequest
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
            'items_id.*' => 'required|exists:items,id',
            'items_id' => ['array', 'min:1', new ItemsOwnerSameAndNotReceiver($this->to_user_id)],
            'transfer_number' => 'required|string|max:20',
            'transfer_date' => 'required|date',
            'to_user_id' => 'required|exists:users,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png'
        ];
    }
}
