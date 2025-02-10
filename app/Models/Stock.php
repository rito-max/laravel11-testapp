<?php

namespace App\Models;

use App\Events\StockSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\Transaction\Type;

class Stock extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getTotalInfo(): Array
    {
        $sellTransactions = $this->transactions->where('type', Type::Sell);
        $buyTransactions = $this->transactions->where('type', Type::Buy);

        $avg_price_buy = 0;
        $avg_price_sell = 0;
        if ($buyTransactions->count() > 0) {
            $buySum = $buyTransactions->reduce(function (int $carry, Transaction $item) {
                return $carry + $item->price * $item->quantity;
            }, 0);
            $avg_price_buy = number_format($buySum / $buyTransactions->sum('quantity'));
        }
        if ($sellTransactions->count() > 0) {
            $sellSum = $sellTransactions->reduce(function (int $carry, Transaction $item) {
                return $carry + $item->price * $item->quantity;
            }, 0);
            $avg_price_sell = number_format($sellSum / $sellTransactions->sum('quantity'));
        }
        $data['avg_price_buy'] = $avg_price_buy;
        $data['avg_price_sell'] = $avg_price_sell;

        $data['quantity'] = number_format($buyTransactions->sum('quantity') - $sellTransactions->sum('quantity'));
        return $data;
    }


    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'saved' => StockSaved::class,
    ];
}
