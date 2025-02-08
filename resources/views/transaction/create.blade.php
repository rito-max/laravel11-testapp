@extends('layouts.app')
 
@section('title', '取引情報登録')
 
@section('content')
    <div class="">
        <a href="{{ route('stock.index') }}">株銘柄一覧</a>
        <a href="{{ route('stock.show', $stock) }}">銘柄詳細</a>
        <p>取引情報登録</p>
    </div>
    <h1>取引情報登録</h1>
    <div class="">
        <form action="{{ route('stock.transaction.store', $stock) }}" method="POST">
            @csrf
            <label>
                取引日
                <input type="date" name="date" value="{{ old('date') }}">
            </label>
            <label>
                金額
                <input type="number" name="price" value="{{ old('price') }}">
            </label>
            <label>
                数量
                <input type="number" name="quantity" value="{{ old('quantity') }}">
            </label>
            <label>
                取引タイプ
                <select name="type">
                    @foreach($options as $op)
                    <option value="{{ $op->value }}" @selected(old('type') == $op->value)>{{ $op->label() }}</option>
                    @endforeach
                </select>
            </label>
            <button class="">登録</button>
        </form>
        @include('components.error')
    </div>
@endsection
