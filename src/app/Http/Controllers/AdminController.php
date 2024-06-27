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

    public function messages(Request $request)
    {
        $query = Comment::query();

        if ($request->filled('user')) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('user') . '%');
            });
        }

        if ($request->filled('item')) {
            $query->whereHas('item', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('item') . '%');
            });
        }

        $comments = $query->with(['user', 'item'])->get()->groupBy('item_id');

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
