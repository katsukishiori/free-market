<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;

class LikeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateLike()
    {
        // 認証ユーザーを作成しログインする
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        // テスト用のアイテムを作成する（この例ではItemモデルが存在することを想定）
        $item = Item::factory()->create();

        // POSTリクエストを送信していいねを付ける
        $response = $this->post(route('like', ['item_id' => $item->id]));

        // リダイレクトを確認する
        $response->assertRedirect();

        // 成功メッセージがセッションに含まれていることを確認する
        $this->assertTrue(session()->has('success'));
        $this->assertEquals('いいねしました！', session('success'));
    }

    public function testDeleteLike()
    {
        // 認証ユーザーを作成しログインする
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        // テスト用のアイテムといいねを作成する
        $item = Item::factory()->create();
        $like = Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // POSTリクエストを送信していいねを解除する
        $response = $this->post(route('unlike', ['item_id' => $item->id]));

        // リダイレクトを確認する
        $response->assertRedirect();
    }
}
