<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\Transaction\Type;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

// TODO: observerでイベントをまとめて監視　ShouldHandleEventsAfterCommitでtransactionをコミットした際に実行されるようにする
// https://laravel.com/docs/11.x/eloquent#observers
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
        // 'deleted_at', TODO: 明示的に必要かどうか、要検証
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
            get: fn (mixed $value, array $attributes) => $attributes['type'] === Type::Buy->value ? '-' . number_format($attributes['price']) : number_format($attributes['price']),
        )->shouldCache();
    }

    /**
     * Get foramtted quantity
     */
    protected function formattedQuantity(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['type'] === Type::Sell->value ? '-' . number_format($attributes['quantity']) : number_format($attributes['quantity']),
        )->shouldCache();
    }

}
