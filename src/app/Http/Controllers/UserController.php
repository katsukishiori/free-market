<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\Item;
use App\Models\SoldItem;


class UserController extends Controller
{
    public function mypage()
    {
        // ログインしているユーザーの sold items を取得し、関連する item をロード
        $soldItems = SoldItem::where('user_id', Auth::id())->with('item')->get();

        $user = auth()->user();
        $profile = $user->profile;
        $imgUrl = $profile ? $profile->img_url : 'default.jpg';

        // ログインしているユーザーの出品した商品を取得
        $userId = Auth::id();
        $items = Item::where('user_id', $userId)->get();

        return view('mypage', compact('imgUrl', 'soldItems', 'items'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        // 現在のユーザーを取得
        $user = Auth::user();

        // ユーザーの名前を更新
        $user->name = $request->input('name');
        $user->save();

        // ユーザーに関連するプロフィールを取得または新規作成
        $profile = $user->profile ?: new Profile(['user_id' => $user->id]);

        // プロフィールの各フィールドをリクエストからの値で更新
        $profile->postcode = $request->input('postcode');
        $profile->address = $request->input('address');
        $profile->building = $request->input('building');

        // 画像のアップロード処理
        if ($request->hasFile('image')) {
            if ($profile->img_url && $profile->img_url != 'default.jpg') {
                Storage::delete('public/images/' . $profile->img_url);
            }

            $image = $request->file('image');
            $path = $image->store('public/images');
            $profile->img_url = basename($path);
        }

        // プロフィールを保存
        $profile->save();

        return redirect()->back()->with('success', 'プロフィールが更新されました！');
    }

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->profile;
        $imgUrl = $profile ? $profile->img_url : 'default.jpg';

        return view('update_profile', compact('user', 'profile', 'imgUrl'));
    }
}
