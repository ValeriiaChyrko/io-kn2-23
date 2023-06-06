<?php

namespace App\Http\Requests\Item;

use App\Rules\Stats\ExistingItemsStatsGroupBy;
use Illuminate\Foundation\Http\FormRequest;

class ItemStatsRequest extends FormRequest
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
            'group_by' => ['required', new ExistingItemsStatsGroupBy()]
        ];
    }
}
