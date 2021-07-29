<?php

namespace App\Http\Controllers;

use App\Models\StockSymbol;
use App\Models\StockSymbolDailyPrice;
use App\Services\StockSymbolDailyPriceService;
use Illuminate\Http\Request;

class StockSymbolDailyPriceController extends Controller
{
    private $stockSymbolDailyPriceService;

    /**
     * StockSymbolDailyPriceController constructor.
     * @param StockSymbolDailyPriceService $stockSymbolDailyPriceService
     */
    public function __construct(StockSymbolDailyPriceService  $stockSymbolDailyPriceService)
    {
        $this->stockSymbolDailyPriceService = $stockSymbolDailyPriceService;
    }

    /**
     * @param StockSymbol $stockSymbol
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(StockSymbol $stockSymbol)
    {
        return $stockSymbol->dailyPrices;
    }

    /**
     * @param StockSymbol $stockSymbol
     * @param Request $request
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function store(StockSymbol $stockSymbol, Request $request)
    {
        $stockSymbolDailyPrice = new StockSymbolDailyPrice($request->all());
        return $stockSymbol->dailyPrices()->save($stockSymbolDailyPrice);
    }

    /**
     * @param StockSymbol $stockSymbol
     * @param $day
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function show(StockSymbol $stockSymbol, $day)
    {
        return $this->stockSymbolDailyPriceService->show($stockSymbol, $day);
    }

    /**
     * @param StockSymbol $stockSymbol
     * @param Request $request
     * @return array
     */
    public function update(StockSymbol $stockSymbol, Request $request)
    {
        $price = $request->get('price');
        $this->stockSymbolDailyPriceService->update(
            $stockSymbol,
            $request->get('day'),
            $price
        );

        return ['price' => $price];
    }

    /**
     * @param StockSymbol $stockSymbol
     * @param Request $request
     */
    public function destroy(StockSymbol $stockSymbol, $day)
    {
        $this->stockSymbolDailyPriceService->destroy($stockSymbol, $day);
    }

    /**
     * @param Request $request
     */
    public function bulkUpdate(Request $request)
    {
        return $this->stockSymbolDailyPriceService->bulkUpdate($request->all());
    }
}
