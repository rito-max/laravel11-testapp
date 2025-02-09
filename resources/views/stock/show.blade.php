@extends('layouts.app')
 
@section('title', '銘柄詳細')
 
@section('content')
    <div class="flex gap-5 mx-auto w-5/6 mt-10">
        <a href="{{ route('stock.index') }}" class="mb-2 text-emerald-600">株銘柄一覧</a>
        >
        <p>{{ $stock->name }}</p>
    </div>
    <h1 class="text-4xl text-center mt-16">{{ $stock->name }}</h1>
    @include('components.success')
    <div class="mx-auto w-5/6 my-16 bg-neutral-100 p-8 rounded-md">
        <h2 class="text-3xl mb-3">集計情報</h2>
        <p class="text-sm text-neutral-400 mb-2">※ 平均単価は、取引数量による重み付けあり</p>
        <p class="mb-2">平均購入単価:<span class="ml-3 font-bold text-xl">{{ $totalInfoArray['avg_price_buy'] }}</span></p>
        <p class="mb-2">平均売却単価:<span class="ml-3 font-bold text-xl">{{ $totalInfoArray['avg_price_sell'] }}</span></p>
        <p>保有数量:<span class="ml-3 font-bold text-xl">{{ $totalInfoArray['quantity'] }}</span></p>
    </div>
    <div class="">
        <div class="text-right mx-auto w-5/6">
            <a href="{{ route('stock.transaction.create', $stock) }}" class="rounded-full  bg-emerald-600  text-white px-5 py-3 text-sm">新規登録</a>
        </div>
        <table class="text-center mx-auto w-5/6 mt-10">
            <thead>
                <tr>
                    <th class="min-w-32 p-3 border-r-2 border-neutral-50">取引日</th>
                    <th class="min-w-32 p-3 border-r-2 border-neutral-50">単価</th>
                    <th class="min-w-32 p-3 border-r-2 border-neutral-50">数量</th>
                    <th class="min-w-32 p-3 border-r-2 border-neutral-50">取引タイプ</th>
                    <th class="min-w-32 p-3 border-neutral-50">操作</th>
                </tr>
            </thead>
            <tbody class="bg-neutral-50">
                @foreach($stock->transactions->sortBy('date') as $transaction)
                <tr>
                    <td class="p-3 border-2 border-white">{{ $transaction->formatted_date }}</td>
                    <td class="p-3 border-2 border-white">{{ $transaction->formatted_price }}</td>
                    <td class="p-3 border-2 border-white">{{ $transaction->quantity }}</td>
                    <td class="p-3 border-2 border-white">{{ $transaction->type_name }}</td>
                    <td class="p-3 border-2 border-white">
                        <form action="{{ route('transaction.destroy', $transaction) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-full  bg-red-400  text-white px-5 py-3 text-sm">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
