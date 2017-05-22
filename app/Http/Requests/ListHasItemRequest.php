<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListHasItemRequest extends FormRequest
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
        return [
            'lists_idList'=>'required',
            'items_idItem'=>'required',
            'price'=>'required|numeric|min:0',
            'qtd'=>'required|numeric|min:1',
            'unit'=>'required',

        ];
    }
}
