<?php

namespace App\Http\Requests\HardwareModel;

use Illuminate\Foundation\Http\FormRequest;

class HardwareModelDeleteRequest extends FormRequest
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
            'idList' => 'array',
            'idList.*' => 'exists:hardware_models,id',
        ];
    }
}
