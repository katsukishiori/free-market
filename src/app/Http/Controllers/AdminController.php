<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:1');
    }

    public function index()
    {
        // ユーザー一覧を取得
        $users = User::all();

        // ビューにユーザー一覧を渡す
        return view('admin', compact('users'));
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // ユーザーを削除
        $user->delete();

        // リダイレクトして成功メッセージを表示
        return redirect()->route('admin')->with('success', 'ユーザーを削除しました。');
    }

    public function messages(Request $request)
    {
        $query = Comment::query();

        if ($request->has('user') && $request->user != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->has('item') && $request->item != '') {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->item . '%');
            });
        }

        // フィルタリングされたコメントを商品ごとにグループ化
        $comments = $query->with(['user', 'item'])->get()->groupBy('item_id');

        return view('messages', compact('comments'));
    }

    public function mail($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('form_mail', ['user' => $user]);
    }

    // メール送信の処理
    public function send(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $details = [
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
        ];

        // メール送信
        Mail::to($details['email'])->send(new AdminMail($details));

        return redirect()->back()->with('status', 'メールを送信しました！');
    }
}
