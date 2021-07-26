<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockSymbolController;
use App\Http\Controllers\StockSymbolDailyPriceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('stock-symbols', StockSymbolController::class);
Route::apiResource('stock-symbols/{stock_symbol}/daily-prices', StockSymbolDailyPriceController::class)->except(['destroy', 'show']);
Route::delete('stock-symbols/{stock_symbol}/daily/{day}/prices',StockSymbolDailyPriceController::class . '@destroy');
Route::get('stock-symbols/{stock_symbol}/daily/{day}/prices', StockSymbolDailyPriceController::class . '@show');
Route::post('stock-symbols-daily-price', StockSymbolDailyPriceController::class . '@bulkUpdate');
