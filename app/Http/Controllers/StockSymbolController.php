<?php

namespace App\Http\Controllers;

use App\Models\StockSymbol;
use Illuminate\Http\Request;

class StockSymbolController extends Controller
{
    /**
     * @return StockSymbol[]|array[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return [
                [
                    'id'=> 1,
                    'name'=> 'ABC',
                    'daily_prices'=> [
                        [
                            'id'=> 1,
                            'stock_symbol_id'=> 1,
                            'day'=> '2021-07-25',
                            'price'=> 56.97
                        ],
                        [
                            'id'=> 2,
                            'stock_symbol_id'=> 1,
                            'day'=> '2021-07-26',
                            'price'=> 23.97
                        ],
                        [
                            'id'=> 3,
                            'stock_symbol_id'=> 1,
                            'day'=> '2021-07-27',
                            'price'=> 65.63
                        ],
                        [
                            'id'=> 4,
                            'stock_symbol_id'=> 1,
                            'day'=> '2021-07-28',
                            'price'=> 12.89
                        ],
                    ]
                ]
            ];
        return StockSymbol::all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return StockSymbol::create($request->all());
    }

    /**
     * @param StockSymbol $stockSymbol
     * @return StockSymbol
     */
    public function show(StockSymbol $stockSymbol)
    {
        return $stockSymbol;
    }

    /**
     * @param Request $request
     * @param StockSymbol $stockSymbol
     * @return StockSymbol
     */
    public function update(Request $request, StockSymbol $stockSymbol)
    {
        $stockSymbol->update($request->all());
        return $stockSymbol;
    }

    /**
     * @param StockSymbol $stockSymbol
     */
    public function destroy(StockSymbol $stockSymbol)
    {
        $stockSymbol->dailyPrices()->delete();
        $stockSymbol->delete();
    }
}
