<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Log;

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

        // ビューに soldItems も imgURL も渡す
        return view('mypage', compact('imgUrl', 'soldItems', 'items'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        Log::info('プロフィール更新処理開始');

        // 現在のユーザーを取得
        $user = Auth::user();
        Log::info('ユーザー取得: ', ['user' => $user]);

        // ユーザーの名前を更新
        $user->name = $request->input('name');
        $user->save();
        Log::info('ユーザー名更新: ', ['name' => $user->name]);

        // ユーザーに関連するプロフィールを取得または新規作成
        $profile = $user->profile ?: new Profile(['user_id' => $user->id]);
        Log::info('プロフィール取得または新規作成: ', ['profile' => $profile]);

        // プロフィールの各フィールドをリクエストからの値で更新
        $profile->postcode = $request->input('postcode');
        $profile->address = $request->input('address');
        $profile->building = $request->input('building');
        Log::info('プロフィールフィールド更新: ', [
            'postcode' => $profile->postcode,
            'address' => $profile->address,
            'building' => $profile->building
        ]);

        // 画像のアップロード処理
        if ($request->hasFile('image')) {
            if ($profile->img_url && $profile->img_url != 'default.jpg') {
                Storage::delete('public/images/' . $profile->img_url);
                Log::info('既存の画像削除: ', ['img_url' => $profile->img_url]);
            }

            $image = $request->file('image');
            $path = $image->store('public/images');
            $profile->img_url = basename($path);
            Log::info('新しい画像保存: ', ['img_url' => $profile->img_url]);
        }

        // プロフィールを保存
        $profile->save();
        Log::info('プロフィール保存: ', ['profile' => $profile]);

        return redirect()->back()->with('success', 'プロフィールが更新されました！');
    }

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->profile;
        $imgUrl = $profile ? $profile->img_url : 'default.jpg';
        Log::info('プロフィール画面表示: ', ['user' => $user, 'profile' => $profile, 'imgUrl' => $imgUrl]);
        return view('update_profile', compact('user', 'profile', 'imgUrl'));
    }
}
