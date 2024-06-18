<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Http\Requests\ItemsRequest;
use Illuminate\Support\Facades\Log;


class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        $items = Item::where('id', '!=', 999)->get();
        return view('product_list', compact('items'));
    }

    public function detail($id)
    {
        // 商品情報を取得
        $item = Item::findOrFail($id);

        // 商品に関連付けられたカテゴリアイテムを取得
        $category_item = CategoryItem::where('item_id', $item->id)->first();

        // カテゴリアイテムからカテゴリを取得
        $category = $category_item->category;

        // 商品のconditionを取得
        $condition = $item->condition->name;
        // 商品情報とカテゴリをビューに渡す
        return view('item', compact('item', 'category', 'condition'));
    }

    public function sellView()
    {
        $categories = Category::all();
        $conditions = Condition::all();
    return view('sell', ['categories' => $categories, 'conditions' => $conditions]);
    }

    public function sellCreate(ItemsRequest $request)
    {
        // バリデーション済みのデータを取得
        $validatedData = $request->validated();

        // 画像が存在するか確認
        if ($request->hasFile('img_url')) {
            // 画像の保存
            $image = $request->file('img_url');
            $filename = time() . '.jpg'; // ファイル名をタイムスタンプ.jpgに設定
            $image->storeAs('public/images', $filename);
            $imagePath =  $filename; // 保存パスを設定
        } else {
            // 画像がない場合はバリデーションエラーを返す
            return redirect()->back()->withInput()->withErrors(['img_url' => '画像を選択してください']);
        }

        $maxId = Item::where(
            'id',
            '<>',
            999
        )->max('id');
        $newItemId = ($maxId < 999) ? $maxId + 1 : 11;

        // もし新しい shop_id が1000以上であれば、21に設定する
        if ($newItemId >= 999) {
            $newItemId = 11;
        }

        // 商品情報の保存
        $item = new Item();
        $item->img_url = $imagePath;
        $item->condition_id = $validatedData['condition'];
        $item->name = $validatedData['name'];
        $item->description = $validatedData['description'];
        $item->price = $validatedData['price'];
        $item->user_id = Auth::id(); // ユーザーのIDを設定
        $item->id = $newItemId;
        $item->save();

        // category_itemテーブルに保存
        $categoryItem = new CategoryItem();
        $categoryItem->item_id = $item->id;
        $categoryItem->category_id = $validatedData['category'];
        $categoryItem->save();

        // 成功時のリダイレクト
        return redirect('/sell')->with('success', '商品が出品されました！');
    }
}
