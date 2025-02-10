<?php

namespace App\Observers;

use App\Models\Transaction;
//トランザクション後に、イベントを処理してくれる
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;


class TransactionObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        Log::info($transaction->stock->name . "の銘柄が取引データが新規登録されました。");
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        Log::info($transaction->stock->name . "の銘柄が取引データが削除されました。");
    }
}
