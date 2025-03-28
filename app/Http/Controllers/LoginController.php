<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendLoginMail;

class LoginController extends Controller
{
    public function getLoginForm()
    {
        return view('login.form');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            //ログイン通知メールをキューに追加
            SendLoginMail::dispatch(Auth::user());

            $request->session()->regenerate();
 
            return redirect()->route('stock.index');
        }

        return back()->withErrors([
            'email' => 'ログインできませんでした。入力内容を確認してください。',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
