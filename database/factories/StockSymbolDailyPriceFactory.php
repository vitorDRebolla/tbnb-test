<?php

namespace Database\Factories;

use App\Models\StockSymbol;
use App\Models\StockSymbolDailyPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockSymbolDailyPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StockSymbolDailyPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'stock_symbol_id' => StockSymbol::inRandomOrder()->first()->id,
            'day' => $this->faker->date(),
            'price' => $this->faker->randomFloat(2)
        ];
    }
}
