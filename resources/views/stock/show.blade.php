@extends('layouts.app')
 
@section('title', '銘柄詳細')
 
@section('content')
    <h1>銘柄詳細</h1>
    <p class="">銘柄名</p>
    <h2>{{ $stock->name }}</h2>
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
                @foreach($stock->transactions->sortBy('price') as $transaction)
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
