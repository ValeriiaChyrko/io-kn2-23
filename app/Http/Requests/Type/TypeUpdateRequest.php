<?php

namespace App\Http\Requests\Type;

use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Type $type Model injected via route model binding
 */
class TypeUpdateRequest extends FormRequest
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
                'max:100',
                Rule::unique('types')->ignoreModel($this->type)
            ],
        ];
    }
}
