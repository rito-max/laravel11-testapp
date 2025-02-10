<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LoginController;

Route::middleware('auth')->group(function () {
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
});

//ログイン
Route::get('login', [LoginController::class, 'getLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');