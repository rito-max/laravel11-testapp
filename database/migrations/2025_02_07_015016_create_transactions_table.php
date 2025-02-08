<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->comment('株取引テーブル');
            $table->id();
            $table->unsignedBigInteger('stock_id'); //8バイト
            $table->unsignedMediumInteger('price')->comment('取引価格 3バイト max8桁いける。確実にいけるのは7桁'); //2^24 3バイト 8桁いけるから十分
            $table->unsignedSmallInteger('quantity')->comment('取引量 2バイト max5桁いける。確実にいけるのは4桁'); //2バイト
            $table->date('date')->comment('取引日');
            $table->unsignedTinyInteger('type')->comment('取引タイプ 1:売却 2:購入');
            $table->softDeletes('deleted_at')->comment('soft delete用のカラム');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
