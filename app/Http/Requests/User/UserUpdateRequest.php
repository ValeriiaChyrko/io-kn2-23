<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property User $user Model injected via route model binding
 */
class UserUpdateRequest extends FormRequest
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
            'name' => 'required|min:5|max:100',
            'email' => [
                'required',
                'email:rfc',
                Rule::unique('users')->ignoreModel($this->user)
            ],
            'role_id' => 'required|exists:roles,id',
        ];
    }
}
