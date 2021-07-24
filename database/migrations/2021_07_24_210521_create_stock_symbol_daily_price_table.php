<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSymbolDailyPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_symbol_daily_price', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_symbol_id');
            $table->date('day');
            $table->double('price');
            $table->timestamps();

            $table->foreign('stock_symbol_id')->references('id')->on('stock_symbols');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_symbol_daily_prices');
    }
}
