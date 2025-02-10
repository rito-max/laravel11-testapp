<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\Transaction\Type;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\TransactionObserver;

#[ObservedBy([TransactionObserver::class])]
class Transaction extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'date',
        'price',
        'quantity',
        'type',
        'stock_id',
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Get foramtted date
     */
    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Carbon::parse($attributes['date'])->timezone('Asia/Tokyo')->format('Y年m月d日'),
        )->shouldCache();
    }

    /**
     * Get type name
     */
    protected function typeName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Type::tryfrom($attributes['type'])->label()
        )->shouldCache();
    }

    /**
     * Get foramtted price
     */
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => number_format($attributes['price']),
        )->shouldCache();
    }

    /**
     * Get foramtted quantity
     */
    protected function formattedQuantity(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => number_format($attributes['quantity']),
        )->shouldCache();
    }

}
