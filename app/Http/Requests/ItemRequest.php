<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $idItem = ($this->request->get('idItem'));
        return [
            'name' => 'required|max:100' .
            (isset($idItem) && !empty($idItem)) ?
                '|' . Rule::unique('items')->ignore($idItem, 'idItem') : '',
            'categories_idCategory' => 'required'
        ];
    }
}
