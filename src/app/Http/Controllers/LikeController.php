<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function create($item_id)
    {
        $user_id = auth()->id();

        // いいねが既に存在するかどうかをチェック
        $existingLike = Like::where('user_id', $user_id)->where('item_id', $item_id)->first();

        if ($existingLike) {
            // いいねが既に存在する場合、削除する
            $existingLike->delete();
            $message = 'いいねを解除しました！';
        } else {
            // いいねが存在しない場合、新しいいいねを追加する
            Like::create([
                'user_id' => $user_id,
                'item_id' => $item_id,
            ]);
            $message = 'いいねしました！';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy($item_id)
    {
        $user_id = auth()->id();

        // いいねを検索して削除する
        $like = Like::where('user_id', $user_id)->where('item_id', $item_id)->first();

        if (!$like) {
            // いいねが見つからない場合、リダイレクトしてエラーメッセージを表示
            return redirect()->back()->with('error', 'いいねが見つかりません！');
        }

        $like->delete();

        return redirect()->back()->with('success', 'いいねを取り消しました！');
    }
}
