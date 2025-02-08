@extends('layouts.app')
 
@section('title', '銘柄一覧')
 
@section('content')
    <h1>銘柄一覧</h1>
    <div class="">
        <a href="{{ route('stock.create') }}" class="">新規登録</a>
        @foreach($stocks->chunk(3) as $chunk)
        <ul class="">
            @foreach($chunk as $stock)
                <li>
                    <table>
                        <tbody>
                            <tr>
                                <th>銘柄名</th>
                                <td>{{ $stock->name }}</td>
                            </tr>
                            <tr>
                                <th>取引数</th>
                                <td>{{ $stock->transactions_count }}</td>
                            </tr>
                            <tr>
                                <th>操作</th>
                                <td>
                                    <a href="{{ route('stock.show', $stock) }}">詳細</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            @endforeach
        </ul>
        @endforeach
    </div>
@endsection
