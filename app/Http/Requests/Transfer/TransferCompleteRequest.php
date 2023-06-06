<?php

namespace App\Http\Requests\Transfer;

use App\Rules\TransferUncompleted;
use Illuminate\Foundation\Http\FormRequest;

class TransferCompleteRequest extends FormRequest
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
     * Get all of the input and files for the request.
     *
     * @param array|mixed|null $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['transfer'] = $this->route('transfer');

        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'transfer' => [new TransferUncompleted()],
            'confirmed' => "required|boolean"
        ];
    }
}
