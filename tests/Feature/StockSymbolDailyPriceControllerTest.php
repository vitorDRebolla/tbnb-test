<?php

namespace Tests\Feature;

use App\Models\StockSymbol;
use App\Models\StockSymbolDailyPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockSymbolDailyPriceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetDailyPrices()
    {
        $stockSymbol = StockSymbol::factory()->create();
        $id = $stockSymbol['id'];
        StockSymbolDailyPrice::factory()->create([
            'stock_symbol_id' => $id
        ]);
        $this->get("/api/stock-symbols/$id/daily-prices")->assertSuccessful()->assertJsonCount(1);
        $this->assertDatabaseCount('stock_symbol_daily_price', 1);
    }

    public function testStoreDailyPrices()
    {
        $stockSymbol = StockSymbol::factory()->create();
        $id = $stockSymbol['id'];
        $dailyPrice = StockSymbolDailyPrice::factory()->make([
            'stock_symbol_id' => $id,
            'price' => 22.03
        ])->toArray();
        $this->post("/api/stock-symbols/$id/daily-prices", $dailyPrice)->assertSuccessful();
        $this->assertDatabaseHas('stock_symbol_daily_price', $dailyPrice);
    }

    public function testShowDailyPrice()
    {
        $stockSymbol = StockSymbol::factory()->create([
            'name' => 'TEST-2'
        ])->toArray();

        $id = $stockSymbol['id'];
        $dailyPrice = StockSymbolDailyPrice::factory()->create([
            'stock_symbol_id' => $id
        ])->toArray();
        $day = $dailyPrice['day'];
        $this->get("/api/stock-symbols/$id/daily/$day/prices")->assertSuccessful();
    }

    public function testDestroyDailyPrice()
    {
        $stockSymbol = StockSymbol::factory()->create([
            'name' => 'TEST-4'
        ])->toArray();

        $id = $stockSymbol['id'];
        $dailyPrice = StockSymbolDailyPrice::factory()->create([
            'stock_symbol_id' => $id
        ])->toArray();
        $day = $dailyPrice['day'];

        $this->delete("/api/stock-symbols/$id/daily/$day/prices")->assertSuccessful();
        $this->assertDatabaseCount('stock_symbol_daily_price', 0);
    }
}
