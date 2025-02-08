@extends('layouts.app')
 
@section('title', '銘柄詳細')
 
@section('content')
    <div class="">
        <a href="{{ route('stock.index') }}">株銘柄一覧</a>
        <p>銘柄詳細</p>
    </div>
    <h1>銘柄詳細</h1>
    @include('components.success')
    <h2 class="">銘柄名</h2>
    <p>{{ $stock->name }}</p>
    <h2>保有情報</h2>
    <p>金額: {{ $totalInfoArray['price'] }}</p>
    <p>数量: {{ $totalInfoArray['quantity'] }}</p>
    <div class="">
        <a href="{{ route('stock.transaction.create', $stock) }}" class="">新規登録</a>
        <table class="">
            <thead>
                <th>取引日</th>
                <th>金額</th>
                <th>数量</th>
                <th>取引タイプ</th>
                <th>操作</th>
            </thead>
            <tbody>
                @foreach($stock->transactions->sortBy('date') as $transaction)
                <tr>
                    <td>{{ $transaction->formatted_date }}</td>
                    <td>{{ $transaction->formatted_price }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ $transaction->type_name }}</td>
                    <td>
                        <form action="{{ route('transaction.destroy', $transaction) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
