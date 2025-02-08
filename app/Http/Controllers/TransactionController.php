<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;
use App\Enums\Transaction\Type;

class TransactionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Stock $stock)
    {
        $data['stock'] = $stock;
        $data['options'] = Type::cases();
        return view('transaction.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request, Stock $stock)
    {
        $stock->transactions()->create($request->all());
        session()->flash('success', "取引データを登録しました。");
        return redirect()->route('stock.show', $stock);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        session()->flash('success', "取引データを削除しました。");
        return redirect()->back();
    }
}
