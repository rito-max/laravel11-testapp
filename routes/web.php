<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    // 株銘柄一覧へリダイレクト
    return redirect()->route('stock.index');
});

Route::resource('stock', StockController::class);
Route::resource('stock.transaction', TransactionController::class)->only([
    'create',
    'store',
    'destroy',
])->shallow();