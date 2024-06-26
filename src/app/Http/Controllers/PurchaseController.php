<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\SoldItem;
use App\Models\Address;


class PurchaseController extends Controller
{
    // 商品購入ページ
    public function index($id)
    {
        $item = Item::findOrFail($id);

        return view('purchase', ['item_id' => $id, 'item' => $item]);
    }

    // 商品購入
    public function purchase($item_id)
    {
        $item = Item::findOrFail($item_id);

        SoldItem::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('mypage')->with('success', '商品を購入しました。');
    }

    //配送先変更ページ
    public function address($id)
    {
        $item = Item::findOrFail($id);

        return view('address_change', ['item' => $item, 'item_id' => $item->id]);
    }

    // 配送先変更
    public function updateAddress(AddressRequest $request, $item_id)
    {
        $user_id = Auth::id();

        $item = Item::findOrFail($item_id);

        $formData = $request->validated();

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
