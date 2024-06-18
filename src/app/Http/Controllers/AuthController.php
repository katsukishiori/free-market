<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Log;
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
            // ログイン成功時の処理

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
                        // その他の役割に対する処理を追加する場合はここに追記
                        // デフォルトのリダイレクト先を設定
                        return redirect('/');
                }
            }

            // 役割が見つからない場合の処理
            return redirect('/')->with('error', '役割が見つかりません。');
        } else {
            // ログイン失敗時の処理
            return redirect('/login')->with('error', 'メールアドレスまたはパスワードが間違っています。');
        }
    }
}
