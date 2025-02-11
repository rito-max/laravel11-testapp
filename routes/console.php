<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\Transaction;
use Illuminate\Support\Facades\Schedule;

// prune対象モデルを明示した方が、意図しない削除を防げると思う！
Schedule::command('model:prune', [
    '--model' => [Transaction::class],
])->daily();