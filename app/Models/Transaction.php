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
use Illuminate\Database\Eloquent\Prunable;
use Log;
use Illuminate\Database\Eloquent\Builder;

#[ObservedBy([TransactionObserver::class])]
class Transaction extends Model
{
    use SoftDeletes, HasFactory, Prunable;

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
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::whereNotNull('deleted_at');
    }

    /**
     * prune直前に、関連するファイルを削除したりできる。とりあえずログを出しておく。
     * deleted,deleting,pruningのモデルイベントをリッスンする必要がない場合は、mass pruningすることで、prune処理が効率的になることを覚えておく。
     * https://laravel.com/docs/11.x/eloquent#mass-pruning
     */
    protected function pruning(): void
    {
        $cnt = self::whereNotNull('deleted_at')->count();
        Log::info("これからpruneします。削除対象データ数は{$cnt}件です");
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
