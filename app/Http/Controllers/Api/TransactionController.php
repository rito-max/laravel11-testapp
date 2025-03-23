<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Gate;
use Auth;
use Log;

class TransactionController extends Controller
{
    public function getTransaction(Request $request)
    {
        $id = $request->stock_id;
        if (is_null($id) || !$transactions = Transaction::where('stock_id', $id)->get()) {
            return ['error' => 'パラメータ不正です'];
        }

        
        $isEditor = Gate::check('isEditor', Auth::user());
        
        $data = $transactions->sortBy('date')->values()->map(fn ($t) =>  [
                'id' => $t->id,
                'formatted_date' => $t->formatted_date,
                'formatted_price' => $t->formatted_price,
                'quantity' => $t->quantity,
                'type_name' => $t->type_name,
            ]);

        return response()->json($data);
    }

    public function getIsEditor()
    {
        //編集権限チェック
        return Gate::check('isEditor', Auth::user());
    }

    public function deleteTransaction($id)
    {
        if (is_null($id) || !$transaction = Transaction::find($id)) {
            return ['error' => 'パラメータ不正です'];
        }
        //権限チェック（via-the-user-model）
        if (Auth::user()->cannot('delete', $transaction)) {
            return ['error' => 'パラメータ不正です'];
        }

        return $transaction->delete();
    }
}
