<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockSymbolRequest extends FormRequest
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
        $id = (int)$this->request->get('id');
        return [
            'name' => [
                'required',
                $id === 0 ? Rule::unique('stock_symbols') : Rule::unique('stock_symbols')->ignore($id),
            ]
        ];
    }
}
