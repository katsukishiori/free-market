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
use App\Models\RoleUser;
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

        $roleUser = RoleUser::where('user_id', $item->user_id)->first();

        $item->description = str_replace("\n", '<br>', $item->description);

        // 商品情報とカテゴリをビューに渡す
        return view('item', compact('item', 'category', 'condition', 'roleUser'));
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
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            // データベースに保存する画像パスを設定
            $imagePath = $filename; // 例：123456789.jpg
        } else {
            // 画像がない場合はバリデーションエラーを返す
            return redirect()->back()->withInput()->withErrors(['img_url' => '画像を選択してください']);
        }

        // 現在の最大の id を取得
        $maxId = Item::where('id', '<>', 999)->max('id');

        // 新しい id を決定
        $newItemId = ($maxId < 999) ? $maxId + 1 : 1;

        // もし新しいidがすでに存在する場合、次の利用可能なidを探す
        while (Item::where('id', $newItemId)->exists()) {
            $newItemId++;
            // 新しい id が 999 未満であることを確認
            if ($newItemId >= 999) {
                $newItemId = 1; // 1 から再スタート
            }
        }


        // 商品情報の保存
        $item = new Item();
        $item->id = $newItemId;
        $item->img_url = $imagePath;
        $item->condition_id = $validatedData['condition'];
        $item->name = $validatedData['name'];
        $item->description = $validatedData['description'];
        $item->price = $validatedData['price'];
        $item->user_id = Auth::id();
        $item->save();

        // category_itemテーブルに保存
        $categoryItem = new CategoryItem();
        $categoryItem->item_id = $item->id;
        $categoryItem->category_id = $validatedData['category'];
        $categoryItem->save();

        // 成功メッセージをセッションに保存
        session()->flash('success', '商品が出品されました。');

        return redirect('/sell'); // 必要に応じて適切なリダイレクト先を設定
    }
}
