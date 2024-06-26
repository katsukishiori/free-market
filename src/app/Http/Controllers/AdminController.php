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

    // 管理者画面
    public function index()
    {
        $users = User::all();

        return view('admin', compact('users'));
    }

    // ユーザー削除
    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin')->with('success', 'ユーザーを削除しました。');
    }

    // ショップとユーザーのやり取り確認
    public function messages(Request $request)
    {
        $query = Comment::query()->with('user');

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

        // コメントを商品ごとにグループ化
        $comments = $query->with(['user', 'item'])->get();

        return view('messages', compact('comments'));
    }

    public function mail($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('form_mail', ['user' => $user]);
    }

    // メール送信
    public function send(Request $request)
    {
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
