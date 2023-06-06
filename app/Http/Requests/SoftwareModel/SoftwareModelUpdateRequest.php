<?php

namespace App\Http\Requests\SoftwareModel;

use App\Models\SoftwareModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property SoftwareModel $software_model Model injected via route model binding
 */
class SoftwareModelUpdateRequest extends FormRequest
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
            'title' => [
                'required',
                'min:1',
                'max:200',
                Rule::unique('software_models')->ignoreModel($this->software_model)
            ]
        ];
    }
}
