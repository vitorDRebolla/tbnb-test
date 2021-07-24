<?php

namespace App\Http\Controllers;

use App\Models\StockSymbol;
use Illuminate\Http\Request;

class StockSymbolController extends Controller
{
    /**
     * @return StockSymbol[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
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
        $stockSymbol->delete();
    }
}
