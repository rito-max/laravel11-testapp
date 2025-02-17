<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


//トークン発行
Route::post('/tokens/create', [ApiController::class, 'createToken']);

// 認証後のみ実行可能
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/stocks', [ApiController::class, 'getStocks']);
    // edit権限保有時のみ実行可能
    Route::post('/stock/create', [ApiController::class, 'createStock'])->middleware(['ability:edit']);
});