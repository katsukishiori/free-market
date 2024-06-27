<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Testing\File;
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

    use RefreshDatabase;

    public function testIndex()
    {
        Item::factory()->count(10)->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('product_list');

        // itemsに正しいデータが渡されていることを確認
        $response->assertViewHas('items', function ($items) {
            // IDが999のアイテムが含まれていないことを確認
            return !$items->contains('id', 999);
        });

        $response->assertViewHas('items');

        $response->assertViewHas('items', function ($items) {
            return $items instanceof \Illuminate\Database\Eloquent\Collection;
        });
    }

    public function testDetail()
    {

        $item = Item::factory()->create();
        $category = Category::factory()->create();
        $categoryItem = CategoryItem::factory()->create([
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertViewIs('item');

        $response->assertViewHas('item', $item);
        $response->assertViewHas('category', $category);
        $response->assertViewHas('condition', $item->condition->name);
    }

    public function testSellCreate()
    {
        /** @var Authenticatable $user */

        $user = User::factory()->create();
        $this->actingAs($user);

        $file = File::create('avatar.jpg', 200, 200);

        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        // テスト用のリクエストデータを準備します
        $requestData = [
            'name' => 'テスト商品',
            'description' => 'この商品は20文字以上のテスト商品です。',
            'price' => '1000',
            'category' => $category->id, // テストで使用するカテゴリーのID
            'condition' => $condition->id, // テストで使用する商品状態のID
            'img_url' => $file,
        ];

        $response = $this->post('/sell', $requestData);

        // バリデーションエラーがないことを確認
        $response->assertSessionHasNoErrors();

        $response->assertRedirect('/sell');

        $this->assertEquals('商品が出品されました。', session('success'));

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'description' => 'この商品は20文字以上のテスト商品です。',
            'price' => '1000',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('category_item', [
            'category_id' => $category->id,
        ]);
    }

    public function testSellView()
    {
        /** @var Authenticatable $user */

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
