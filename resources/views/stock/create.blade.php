@extends('layouts.app')
 
@section('title', '銘柄登録')
 
@section('content')
    <div class="">
        <a href="{{ route('stock.index') }}">株銘柄一覧</a>
        <p>銘柄登録</p>
    </div>
    <h1>銘柄登録</h1>
    <div class="">
        <form action="{{ $url }}" method="POST">
            @if($url !== route('stock.store'))
                @method('PUT')
            @endif
            @csrf
            <label>
                <p>銘柄名</p>
                <input type="text" name="name" value="{{ old('name', $stock) }}">
                <button class="">登録</button>
            </label>
        </form>
        @include('components.error')
    </div>
@endsection
