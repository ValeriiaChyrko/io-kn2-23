<?php

namespace App\Http\Requests\SoftwareModel;

use Illuminate\Foundation\Http\FormRequest;

class SoftwareModelDeleteRequest extends FormRequest
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
            'idList.*' => 'exists:software_models,id',
        ];
    }
}
