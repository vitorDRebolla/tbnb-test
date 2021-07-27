<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSymbol extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dailyPrices()
    {
        return $this->hasMany(StockSymbolDailyPrice::class)->orderBy('day');
    }
}
