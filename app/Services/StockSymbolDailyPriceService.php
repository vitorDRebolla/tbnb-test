<?php

namespace App\Services;

use App\Models\StockSymbol;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

Class StockSymbolDailyPriceService
{
    /**
     * @param StockSymbol $stockSymbol
     * @param $day
     * @return Collection
     */
    public function show(StockSymbol $stockSymbol, $day): Collection
    {
        return $this->getStockSymbolPriceByDay($stockSymbol, $day)->get();
    }

    /**
     * @param StockSymbol $stockSymbol
     * @param $day
     * @param $price
     */
    public function update(StockSymbol $stockSymbol, $day, $price)
    {
        $this->getStockSymbolPriceByDay($stockSymbol, $day)->update($price);
    }

    /**
     * @param StockSymbol $stockSymbol
     * @param $day
     */
    public function destroy(StockSymbol $stockSymbol, $day)
    {
       $this->getStockSymbolPriceByDay($stockSymbol, $day)->delete();
    }

    /**
     * @param $data
     */
    public function bulkUpdate($data)
    {
        DB::beginTransaction();
        try {
            foreach ($data as $item) {
                $stockSymbol = StockSymbol::where('name', $item['name'])->first();
                $this->update($stockSymbol, $item['day'], $item['price']);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

    }

    /**
     * @param StockSymbol $stockSymbol
     * @param $day
     * @return HasMany
     */
    private function getStockSymbolPriceByDay(StockSymbol $stockSymbol, $day): HasMany
    {
        return $stockSymbol->dailyPrices()->where('day', $day);
    }
}
