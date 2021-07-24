<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('stock-symbols', 'StockSymbolController');
Route::apiResource('stock-symbols/{stock_symbol}/daily-prices', 'StockSymbolDailyPriceController')->except('destroy');
Route::post('stock-symbols/{stock_symbol}/daily-prices/delete', 'StockSymbolDailyPriceController@destroy');
Route::get('stock-symbols/{stock_symbol}/daily/{day}/prices', 'StockSymbolDailyPriceController@show');
Route::post('stock-symbols-daily-price', 'StockSymbolDailyPriceController@bulkUpdate');
