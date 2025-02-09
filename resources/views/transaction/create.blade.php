@extends('layouts.app')
 
@section('title', '取引情報登録')
 
@section('content')
    <div class="flex gap-5 mx-auto w-5/6 mt-10">
        <a href="{{ route('stock.index') }}" class="mb-2 text-emerald-600">株銘柄一覧</a>
        >
        <a href="{{ route('stock.show', $stock) }}" class="mb-2 text-emerald-600">銘柄詳細</a>
        >
        <p>取引情報登録</p>
    </div>
    <div class="gap-5 mx-auto w-5/6 mt-10">
        <h1 class="text-4xl text-center mt-16">取引情報登録</h1>
        <form action="{{ route('stock.transaction.store', $stock) }}" method="POST" class="my-16 flex flex-col">
            @csrf
            <label class="mb-5">
                <p class="font-bold">取引日</p>
                <input type="date" name="date" value="{{ old('date') }}" class="bg-neutral-100 px-2 py-3 mt-2 rounded-md w-96">
            </label>
            <label>
                <p class="font-bold mt-4">金額</p>
                <input type="number" name="price" value="{{ old('price') }}" class="bg-neutral-100 px-2 py-3 mt-2 rounded-md w-96">
            </label>
            <label>
                <p class="font-bold mt-4">数量</p>
                <input type="number" name="quantity" value="{{ old('quantity') }}" class="bg-neutral-100 px-2 py-3 mt-2 rounded-md w-96">
            </label>
            <label>
                <p class="font-bold mt-4">取引タイプ</p>
                <select name="type" class="bg-neutral-100 px-2 py-3 mt-2 rounded-md w-96">
                    @foreach($options as $op)
                    <option value="{{ $op->value }}" @selected(old('type') == $op->value)>{{ $op->label() }}</option>
                    @endforeach
                </select>
            </label>
            <button class="rounded-full bg-emerald-600 text-white mt-8 px-5 py-3 text-sm w-40">登録</button>
        </form>
        @include('components.error')
    </div>
@endsection
