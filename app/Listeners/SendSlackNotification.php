<?php

namespace App\Listeners;

use App\Events\StockSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendSlackNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StockSaved $event): void
    {
        //本当はslackとかに通知する想定。簡易的にログが吐き出されていればOK
        Log::info($event->stock->name . "の銘柄が新規登録されました。");
    }
}
