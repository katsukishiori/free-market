<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    public function index($id)
    {
        // 商品情報を取得
        $item = Item::findOrFail($id);

        // コメントとユーザー情報を取得
        $comments = Comment::where('item_id', $id)->with('user.profile')->get();

        return view('comment', compact('item', 'comments'));
    }

    public function create(CommentRequest $request, $id)
    {
        // 商品情報を取得
        $item = Item::findOrFail($id);

        // 商品に関連付けられたカテゴリアイテムを取得
        $category_item = CategoryItem::where('item_id', $item->id)->first();

        // カテゴリアイテムからカテゴリを取得
        $category = $category_item->category;

        // 商品のconditionを取得
        $condition = $item->condition->name;

        // ログインユーザーのIDを取得
        $user_id = Auth::id();

        // コメントを保存
        Comment::create([
            'user_id' => $user_id,
            'item_id' => $id,
            'comment' => $request->input('comment')
        ]);

        // コメント一覧を取得
        $comments = Comment::where('item_id', $id)->get();

        // 商品情報、カテゴリ、コメント一覧をビューに渡す
        return view('comment', compact('item', 'category', 'condition', 'comments'));
    }

    public function destroy(Item $item, Comment $comment)
    {
        // ログインしているユーザーがコメントの所有者であることを確認
        if ($comment->user_id === Auth::id()) {
            $comment->delete();
            return redirect()->back()->with('message', 'コメントが削除されました');
        }
    }
}
