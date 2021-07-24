<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSymbolDailyPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_symbol_id',
        'day',
        'price'
    ];
}
