<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\Item;
use App\Models\SoldItem;


class UserController extends Controller
{
    // マイページ表示
    public function mypage()
    {
        $soldItems = SoldItem::where('user_id', Auth::id())->with('item')->get();

        $user = auth()->user();
        $profile = $user->profile;
        $imgUrl = $profile ? $profile->img_url : 'default.jpg';

        $userId = Auth::id();
        $items = Item::where('user_id', $userId)->get();

        return view('mypage', compact('imgUrl', 'soldItems', 'items'));
    }

    // プロフィール更新処理
    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->input('name');
        $user->save();

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
        } else {
            // 画像が選択されていない場合にデフォルト画像を設定
            if (!$profile->img_url) {
                $profile->img_url = 'default.jpg';
            }
        }

        // プロフィールを保存
        $profile->save();

        return redirect()->back()->with('success', 'プロフィールが更新されました！');
    }

    // プロフィール編集画面
    public function profile()
    {
        $user = auth()->user();
        $profile = $user->profile;
        $imgUrl = $profile ? $profile->img_url : 'default.jpg';

        return view('update_profile', compact('user', 'profile', 'imgUrl'));
    }
}
