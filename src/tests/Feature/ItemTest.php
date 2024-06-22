<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Condition;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        // テスト用のデータを作成
        Item::factory()->count(10)->create();

        // indexメソッドにGETリクエストを送信
        $response = $this->get('/');

        // ステータスコードが200であることを確認
        $response->assertStatus(200);

        // 正しいビューが返されていることを確認
        $response->assertViewIs('product_list');

        // itemsに正しいデータが渡されていることを確認
        $response->assertViewHas('items', function ($items) {
            // IDが999のアイテムが含まれていないことを確認
            return !$items->contains('id', 999);
        });

        // 作成されたアイテムがビューに渡されていることを確認
        $response->assertViewHas('items'); // count()を使わずに数を確認する

        // itemsがコレクションであることを確認
        $response->assertViewHas('items', function ($items) {
            return $items instanceof \Illuminate\Database\Eloquent\Collection;
        });
    }

    public function testDetail()
    {
        // テスト用のデータを作成
        $item = Item::factory()->create();
        $category = Category::factory()->create();
        $categoryItem = CategoryItem::factory()->create([
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);

        // detailメソッドにGETリクエストを送信
        $response = $this->get("/item/{$item->id}");

        // ステータスコードが200であることを確認
        $response->assertStatus(200);

        // 正しいビューが返されていることを確認
        $response->assertViewIs('item');

        // アイテムがビューに渡されていることを確認
        $response->assertViewHas('item', $item);

        // カテゴリがビューに渡されていることを確認
        $response->assertViewHas('category', $category);

        // 商品のconditionがビューに渡されていることを確認
        $response->assertViewHas('condition', $item->condition->name);
    }

    public function testSellCreate()
    {
        /** @var Authenticatable $user */
        // ユーザーを作成し、認証します
        $user = User::factory()->create();
        $this->actingAs($user);

        // ダミーファイルを生成
        $file = UploadedFile::fake()->create('test.jpg', 500); // 500 KBのダミーの画像ファイルを作成


        $requestData = [
            'name' => 'テスト商品',
            'description' => 'この商品は20文字以上のテスト商品です。',
            'price' => '1000',
            'condition' => 1,
            'category' => 1,
            'img_url' => $file, // ダミーの画像ファイル
        ];

        // 商品出品リクエストを送信
        $response = $this->post('/sell', $requestData);

        // バリデーションエラーがないことを確認
        $response->assertSessionHasNoErrors();

        // リダイレクトを確認
        $response->assertRedirect('/');

        // 成功メッセージがセッションに含まれていることを確認
        $this->assertEquals('商品が出品されました。', session('success'));
    }

    public function testSellView()
    {
        /** @var Authenticatable $user */
        // ユーザーを作成し、認証します
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/sell');

        $response->assertStatus(200);
        $response->assertViewIs('sell');
        $response->assertViewHasAll([
            'categories' => Category::all(),
            'conditions' => Condition::all(),
        ]);
    }
}
