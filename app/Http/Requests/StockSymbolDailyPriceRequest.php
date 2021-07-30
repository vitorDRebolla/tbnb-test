<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockSymbolDailyPriceRequest extends FormRequest
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
        $data = $this->request->all();
        $ruleUnique = Rule::unique('stock_symbol_daily_price')
            ->where('stock_symbol_id', $data['stock_symbol_id']);
        $today = Carbon::today();

        return [
            'day' => [
                'required',
                $data['id'] ? $ruleUnique->ignore($data['id']) : $ruleUnique,
                'date',
                "before_or_equal:$today"
            ],
            'price' => 'numeric'
        ];
    }
}
