<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Auth;
use App\Mail\LoginMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendLoginMail implements ShouldQueue
{
    use Queueable;

    /**
     * 最大試行回数
     *
     * @var int
     */
    public $tries = 5;

    /**
     * タイムアウト設定（デフォルトは60）
     *
     * @var int
     */
    public $timeout = 90;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //遅い処理をsleepで再現
        sleep(2);
        Mail::to($this->user)->send(new LoginMail($this->user));
    }
}
