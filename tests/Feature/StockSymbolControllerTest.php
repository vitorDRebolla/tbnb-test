<?php

namespace Tests\Feature;

use App\Models\StockSymbol;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockSymbolControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetStockSymbols()
    {
        StockSymbol::factory()->create();
        $this->get('/api/stock-symbols')->assertSuccessful()->assertJsonCount(1);
        $this->assertDatabaseCount('stock_symbols', 1);
    }

    /**
     * @dataProvider validStockSymbolProvider
     */
    public function testStoreStockSymbols(array $stockSymbol)
    {
        $this->post('/api/stock-symbols', $stockSymbol)->assertSuccessful();
        $this->assertDatabaseHas('stock_symbols', $stockSymbol);
    }

    /**
     *
     */
    public function testSameNameStoreStockSymbols()
    {
        StockSymbol::factory()->create([
            'name' => 'TEST'
        ])->toArray();

        $stockSymbol = StockSymbol::factory()->make([
            'name' => 'TEST'
        ])->toArray();

        $this->post('/api/stock-symbols', $stockSymbol)->assertStatus(302);
        $this->assertDatabaseCount('stock_symbols', 1);
    }

    /**
     *
     */
    public function testInvalidNameStoreStockSymbols()
    {
        $stockSymbol = StockSymbol::factory()->make([
            'name' => ''
        ])->toArray();

        $this->post('/api/stock-symbols', $stockSymbol)->assertStatus(302);
        $this->assertDatabaseCount('stock_symbols', 0);
    }

    /**
     *
     */
    public function testShowStockSymbols()
    {
        $stockSymbol = StockSymbol::factory()->create([
            'name' => 'JHG-33'
        ])->toArray();

        $id = $stockSymbol['id'];

        $this->get("/api/stock-symbols/$id")->assertSuccessful();
    }

    /**
     *
     */
    public function testUpdateStockSymbols()
    {
        $stockSymbol = StockSymbol::factory()->create([
            'name' => 'TEST'
        ])->toArray();

        $id = $stockSymbol['id'];
        $updateData = [
            'name' => 'CHANGED',
        ];

        $this->put("/api/stock-symbols/$id", $updateData)->assertSuccessful();
        $this->assertDatabaseHas('stock_symbols', $updateData);
    }

    /**
     *
     */
    public function testSameNameUpdateStockSymbols()
    {
        StockSymbol::factory()->create([
            'name' => 'TEST'
        ])->toArray();

        $stockSymbol = StockSymbol::factory()->create([
            'name' => 'TEST-2'
        ])->toArray();

        $id = $stockSymbol['id'];
        $updateData = [
            'name' => 'TEST',
        ];

        $this->put("/api/stock-symbols/$id", $updateData)->assertStatus(302);
        $this->assertDatabaseHas('stock_symbols', $stockSymbol);
    }

    /**
     *
     */
    public function testInvalidNameUpdateStockSymbols()
    {
        StockSymbol::factory()->create([
            'name' => 'TEST'
        ])->toArray();

        $stockSymbol = StockSymbol::factory()->create([
            'name' => 'TEST-2'
        ])->toArray();

        $id = $stockSymbol['id'];
        $updateData = [
            'name' => '',
        ];

        $this->put("/api/stock-symbols/$id", $updateData)->assertStatus(302);
        $this->assertDatabaseHas('stock_symbols', $stockSymbol);
    }

    /**
     *
     */
    public function testDestroyStockSymbols()
    {
        $stockSymbol = StockSymbol::factory()->create([
            'name' => 'TEST'
        ])->toArray();

        $id = $stockSymbol['id'];

        $this->delete("/api/stock-symbols/$id")->assertSuccessful();
        $this->assertDatabaseCount('stock_symbols', 0);
    }

    /**
     * @return \string[][][]
     */
    public function validStockSymbolProvider()
    {
        return [
            [
               [
                   'name' => 'AGOI-39'
               ]
            ],
            [
               [
                   'name' => 'GOWP9'
               ]
            ],
        ];
    }
}
