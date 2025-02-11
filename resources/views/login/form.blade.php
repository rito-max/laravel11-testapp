@extends('layouts.app')
 
@section('title', 'ログイン')
 
@section('content')
    <div class="gap-5 mx-auto w-5/6 mt-10">
        <h1 class="text-4xl text-center mt-16">株管理アプリ ログイン画面</h1>
        <form action="{{ route('login') }}" method="POST" class="my-16 flex flex-col">
            @csrf
            <label class="mb-5">
                <p class="font-bold">メールアドレス</p>
                <input type="text" name="email" value="{{ old('email') }}" class="bg-neutral-100 px-2 py-3 mt-2 rounded-md w-96">
            </label>
            <label class="mb-5">
                <p class="font-bold">パスワード</p>
                <input type="password" name="password" value="{{ old('password') }}" class="bg-neutral-100 px-2 py-3 mt-2 rounded-md w-96">
            </label>
            <button class="rounded-full bg-emerald-600 text-white mt-8 px-5 py-3 text-sm w-40">ログイン</button>
        </form>
        @include('components.error')
</div>
@endsection
