<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockSymbolRequest;
use App\Models\StockSymbol;
use Illuminate\Http\Request;

class StockSymbolController extends Controller
{
    /**
     * @return StockSymbol[]|array[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return StockSymbol::with('dailyPrices')->orderBy('name')->get();
    }

    /**
     * @param StockSymbolRequest $request
     * @return mixed
     */
    public function store(StockSymbolRequest $request)
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
     * @param StockSymbolRequest $request
     * @param StockSymbol $stockSymbol
     * @return StockSymbol
     */
    public function update(StockSymbolRequest $request, StockSymbol $stockSymbol)
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
