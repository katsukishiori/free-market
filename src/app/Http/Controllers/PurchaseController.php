<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\SoldItem;
use App\Models\Address;


class PurchaseController extends Controller
{
    public function index($id)
    {
        $item = Item::findOrFail($id);

        return view('purchase', ['item_id' => $id, 'item' => $item]);
    }

    public function purchase($item_id)
    {
        $item = Item::findOrFail($item_id);

        // アイテムの購入処理
        SoldItem::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('mypage')->with('success', '商品を購入しました。');
    }

    public function address($id)
    {
        $item = Item::findOrFail($id);

        return view('address_change', ['item' => $item, 'item_id' => $item->id]);
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        // ログインユーザーのIDを取得
        $user_id = Auth::id();

        // 対応するItemモデルを取得
        $item = Item::findOrFail($item_id);

        // バリデーション済みのデータを取得
        $formData = $request->validated();

        // 住所データを保存
        Address::updateOrCreate(
            ['item_id' => $item->id, 'user_id' => $user_id],
            [
                'postcode' => $formData['postcode'],
                'address' => $formData['address'],
            ]
        );

        return redirect('/')->with('message', '住所が更新されました!');
    }
}
