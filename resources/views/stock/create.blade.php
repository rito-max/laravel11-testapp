@extends('layouts.app')
 
@section('title', '銘柄登録')
 
@section('content')
    <div class="flex gap-5 mx-auto w-5/6 mt-10">
        <a href="{{ route('stock.index') }}" class="mb-2 text-emerald-600">株銘柄一覧</a>
        >
        <p>銘柄登録</p>
    </div>
    <div class="gap-5 mx-auto w-5/6 mt-10">
        <h1 class="text-4xl text-center mt-16">銘柄登録</h1>
        <form action="{{ $url }}" method="POST" class="my-16 flex flex-col">
            @if($url !== route('stock.store'))
                @method('PUT')
            @endif
            @csrf
            <label class="mb-5">
                <p class="font-bold">銘柄名</p>
                <input type="text" name="name" value="{{ old('name', $stock) }}" class="bg-neutral-100 px-2 py-3 mt-2 rounded-md w-96">
            </label>
            <button class="rounded-full bg-emerald-600 text-white mt-8 px-5 py-3 text-sm w-40">登録</button>
        </form>
        @include('components.error')
</div>
@endsection
