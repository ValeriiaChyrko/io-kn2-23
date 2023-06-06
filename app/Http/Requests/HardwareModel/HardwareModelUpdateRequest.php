<?php

namespace App\Http\Requests\HardwareModel;

use App\Models\HardwareModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property HardwareModel $hardware_model Model injected via route model binding
 */
class HardwareModelUpdateRequest extends FormRequest
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
                Rule::unique('hardware_models')->ignoreModel($this->hardware_model)
            ]
        ];
    }
}
