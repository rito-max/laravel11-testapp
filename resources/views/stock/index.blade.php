@extends('layouts.app')
 
@section('title', '銘柄一覧')
 
@section('content')
    <h1 class="text-4xl text-center mt-16">銘柄一覧</h1>
    @include('components.success')
    <div class="mx-auto w-5/6 my-16">
        @can('isEditor')
            <div class="text-right mx-auto w-5/6 mb-10">
                <a href="{{ route('stock.create') }}" class="rounded-full  bg-emerald-600  text-white px-5 py-3 text-sm">新規登録</a>
            </div>
        @endcan
        @foreach($stocks->chunk(2) as $chunk)
        <ul class="flex justify-between items-center gap-3 my-3">
            @foreach($chunk as $stock)
                <li class="p-3 w-1/2 bg-neutral-100 rounded-md h-80">
                    <table>
                        <tbody>
                            <tr class="flex my-3 flex-col text-left">
                                <th class="mb-2">銘柄名</th>
                                <td>{{ $stock->name }}</td>
                            </tr>
                            <tr class="flex my-3 flex-col text-left">
                                <th class="mb-2">取引数</th>
                                <td>{{ $stock->transactions_count }}</td>
                            </tr>
                            <tr class="flex my-3 flex-col text-left">
                                <th class="mb-2">操作</th>
                                <td class="flex my-3 gap-2 items-start">
                                    <a href="{{ route('stock.show', $stock) }}" class="rounded-full  bg-indigo-600  text-white px-5 py-3 text-sm">詳細</a>
                                    @can('isEditor')
                                        <a href="{{ route('stock.edit', $stock) }}" class="rounded-full  bg-emerald-600  text-white px-5 py-3 text-sm">編集</a>
                                        @if($stock->transactions_count === 0)
                                        <form action="{{ route('stock.destroy', $stock) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-full  bg-red-400  text-white px-5 py-3 text-sm">削除</button>
                                        </form>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            @endforeach
        </ul>
        @endforeach
        <div class="flex justify-between my-12">
            @if($stocks->currentPage() !== 1)
            <a href="{{ $stocks->url($stocks->currentPage() - 1) }}" class="text-right">< Prev</a>
            @endif
            @if($stocks->hasMorePages())
            <a href="{{ $stocks->url($stocks->currentPage() + 1) }}" class="text-right ml-auto">Next ></a>
            @endif
        </div>
    </div>
@endsection
