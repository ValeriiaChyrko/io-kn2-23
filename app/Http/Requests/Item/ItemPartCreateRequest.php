<?php

namespace App\Http\Requests\Item;

use App\Models\Item;
use App\Rules\ItemParentable;
use Illuminate\Foundation\Http\FormRequest;

class ItemPartCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Item $item */
        $item = $this->route('item');
        if($item->invoice->approved and !can('edit-approved-invoice')) {
            return false;
        }

        return true;
    }

    /**
     * Get all the input and files for the request.
     *
     * @param array|mixed|null $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $data = parent::all($keys);

        $data['parent'] = $this->route('item');

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
            'parent' => [ new ItemParentable() ],
            'type_id' => 'required|exists:types,id',
            'hardware_model_id' => 'required|exists:hardware_models,id',
            'price' => 'nullable|numeric|max:999999.99'
        ];
    }
}
