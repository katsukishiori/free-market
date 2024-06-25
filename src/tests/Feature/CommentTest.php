<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function testIndex()
    {
        // テスト用のアイテムとコメントを作成
        $item = Item::factory()->create(); // Item のファクトリーを使用して作成

        // indexメソッドにGETリクエストを送信
        $response = $this->get("/item/comment/{$item->id}");

        // リダイレクトを確認
        $response->assertRedirect();
    }

    public function testCreate()
    {
        // テスト用のアイテムを作成
        $item = Item::factory()->create();

        // ダミーのコメントリクエスト
        $requestData = [
            'comment' => 'テストコメント',
        ];

        // createメソッドにPOSTリクエストを送信
        $response = $this->post(route('comment', ['item_id' => $item->id]), $requestData);

        // リダイレクトを確認
        $response->assertRedirect();
    }

    public function testDestroy()
    {
        // テスト用のアイテムとコメントを作成
        $item = Item::factory()->create();
        $comment = Comment::factory()->create(['item_id' => $item->id]);

        // destroyメソッドにDELETEリクエストを送信
        $response = $this->delete(route('comment.destroy', ['comment' => $comment->id]));

        // コメントが削除された場合のリダイレクトを確認
        $response->assertRedirect();
    }
}
