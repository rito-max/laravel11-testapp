<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Http\Requests\StockRequest;
use Illuminate\Support\Facades\Gate;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //権限チェック
        Gate::authorize('viewAny', Stock::class);

        $data['stocks'] = Stock::withCount('transactions')->orderByDesc('updated_at')->simplePaginate(6);
        return view('stock.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //権限チェック
        Gate::authorize('create', Stock::class);

        $data['stock'] = new Stock();
        $data['url'] = route('stock.store');
        return view('stock.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        //権限チェック
        Gate::authorize('create', Stock::class);

        Stock::create($request->all());

        $request->session()->flash('success', '株銘柄を登録しました。');
        return redirect()->route('stock.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //権限チェック
        Gate::authorize('view', $stock);

        $data['stock'] = $stock->load('transactions');
        $data['totalInfoArray'] = $stock->getTotalInfo();
        return view('stock.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //権限チェック
        Gate::authorize('update', $stock);

        $data['stock'] = $stock;
        $data['url'] = route('stock.update', $stock);
        return view('stock.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockRequest $request, Stock $stock)
    {
        //権限チェック
        Gate::authorize('update', $stock);

        $stock->name = $request->name;
        if ($stock->isDirty()) {
            $stock->update();
            $request->session()->flash('success', '株銘柄を更新しました。');
        }
        return redirect()->route('stock.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //権限チェック
        Gate::authorize('delete', $stock);

        $stock->delete();
        session()->flash('success', $stock->name . "の株銘柄を削除しました。");
        return redirect()->route('stock.index');
    }
}
