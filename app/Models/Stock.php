<?php

namespace App\Models;

// use App\Events\StockSaved;
// use App\Events\StockUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    // protected $dispatchesEvents = [
    //     'saved' => StockSaved::class,
    //     'updated' => StockUpdated::class,
    // ];
    // TODO: 後でイベント作る！　ログ吐き出すとかで良いかな！
    // https://laravel.com/docs/11.x/events
}
