<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Enums\User\Role;
use App\Models\Stock;

class ApiController extends Controller
{
    public function createToken(Request $request)
    {
        if (
            !Auth::attempt($request->only('email', 'password')) || 
            !$user = User::where('email', $request['email'])->first()
        ) {
            return response()->json([
                'message' => '認証に失敗しました。'
            ], 401);
        }

        // ability設定、tokenの有効期間を仮で1週間にしておく。
        $ability = $user->role_id === Role::Editor->value ? 'edit' : 'read';
        $token = $user->createToken('api_access', [$ability], now()->addWeek())->plainTextToken;

        return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
        ]);
    }

    public function getStocks()
    {
        return Stock::all();
    }

    public function createStock(Request $request)
    {
        //パラメータチェック＆バリデーション100文字以内
        if (is_null($request->name) || mb_strlen($request->name) > 100) {
            return response()->json([
                'message' => '銘柄名を100文字以内で指定してください。'
            ], 400);
        }
        return Stock::create([
            'name' => $request->name
        ]);
    }
}
