<?php

namespace App\Http\Requests\HardwareModel;

use Illuminate\Foundation\Http\FormRequest;

class HardwareModelCreateRequest extends FormRequest
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
            'title' => 'required|min:1|max:300|unique:hardware_models,title',
        ];
    }
}
