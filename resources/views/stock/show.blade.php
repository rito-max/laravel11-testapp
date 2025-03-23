@extends('layouts.app')
 
@section('title', '銘柄詳細')
 
@section('content')
    <div class="flex gap-5 mx-auto w-5/6 mt-10">
        <a href="{{ route('stock.index') }}" class="mb-2 text-emerald-600">株銘柄一覧</a>
        >
        <p>{{ $stock->name }}</p>
    </div>
    <h1 class="text-4xl text-center mt-16">{{ $stock->name }}</h1>
    <div class="mx-auto w-5/6 my-16 bg-neutral-100 p-8 rounded-md">
        <h2 class="text-3xl mb-3">集計情報</h2>
        <p class="text-sm text-neutral-400 mb-2">※ 平均単価は、取引数量による重み付けあり</p>
        <p class="mb-2">平均購入単価:<span class="ml-3 font-bold text-xl">{{ $totalInfoArray['avg_price_buy'] }}</span></p>
        <p class="mb-2">平均売却単価:<span class="ml-3 font-bold text-xl">{{ $totalInfoArray['avg_price_sell'] }}</span></p>
        <p>保有数量:<span class="ml-3 font-bold text-xl">{{ $totalInfoArray['quantity'] }}</span></p>
    </div>
    @include('components.success')
    <div id="transactions" data-stockid="{{ $stock->id }}"></div>
@endsection

@section('scripts')
    @vite('resources/js/pages/stockDetails.tsx')
@endsection