<?php

namespace App\Http\Requests\Type;

use Illuminate\Foundation\Http\FormRequest;

class TypeCreateRequest extends FormRequest
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
            'title' => 'required|min:1|max:100|unique:types,title',
        ];
    }
}
