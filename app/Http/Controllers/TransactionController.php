<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;
use App\Enums\Transaction\Type;
use Illuminate\Support\Facades\Gate;
use Auth;

class TransactionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Stock $stock)
    {
        //権限チェック（via-the-user-model）
        if (Auth::user()->cannot('create', Transaction::class)) {
            abort(403);
        }

        $data['stock'] = $stock;
        $data['options'] = Type::cases();
        return view('transaction.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request, Stock $stock)
    {
        //権限チェック（via-the-user-model）
        if (Auth::user()->cannot('create', Transaction::class)) {
            abort(403);
        }

        $stock->transactions()->create($request->all());
        session()->flash('success', "取引データを登録しました。");
        return redirect()->route('stock.show', $stock);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //権限チェック（via-the-user-model）
        if (Auth::user()->cannot('delete', $transaction)) {
            abort(403);
        }

        $transaction->delete();
        session()->flash('success', "取引データを削除しました。");
        return redirect()->back();
    }
}
