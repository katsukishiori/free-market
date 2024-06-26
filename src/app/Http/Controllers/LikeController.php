<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    // いいね機能
    public function create($item_id)
    {
        $user_id = auth()->id();

        // いいねが既に存在するかどうかをチェック
        $existingLike = Like::where('user_id', $user_id)->where('item_id', $item_id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $message = 'いいねを解除しました！';
        } else {
            Like::create([
                'user_id' => $user_id,
                'item_id' => $item_id,
            ]);
            $message = 'いいねしました！';
        }

        return redirect()->back()->with('success', $message);
    }

    // いいね削除機能
    public function destroy($item_id)
    {
        $user_id = auth()->id();

        $like = Like::where('user_id', $user_id)->where('item_id', $item_id)->first();

        if (!$like) {

            return redirect()->back()->with('error', 'いいねが見つかりません！');
        }

        $like->delete();

        return redirect()->back()->with('success', 'いいねを取り消しました！');
    }
}
