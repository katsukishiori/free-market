<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\RoleUser;
use App\Http\Requests\AuthorRequest;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(AuthorRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            // ログインしたユーザーのIDを取得
            $userId = Auth::id();

            // ユーザーの役割を取得
            $roleUser = RoleUser::where('user_id', $userId)->first();

            if ($roleUser) {
                // 役割IDを取得
                $roleId = $roleUser->role_id;

                // 役割IDに基づいてリダイレクト先を設定
                switch ($roleId) {
                    case 1:
                        // 管理者の場合の処理
                        return redirect()->route('admin');
                    case 2:
                        // 店舗代表者の場合の処理
                        return redirect()->route('manager');
                        return redirect('/');
                }
            }

            return redirect('/')->with('error', '役割が見つかりません。');
        } else {

            return redirect('/login')->with('error', 'メールアドレスまたはパスワードが間違っています。');
        }
    }
}
