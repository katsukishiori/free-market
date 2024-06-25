<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Manager;
use App\Models\Comment;
use App\Models\Item;


class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function testIndex()
    {
        // テストに必要なデータを作成
        $user = User::factory()->create();
        $manager = Manager::factory()->create(['id' => 999]); // manager_id が 999 のマネージャーを作成

        // Role モデルのファクトリーを使用して role_id が 1 のデータを作成
        Role::factory()->create(['id' => 1, 'name' => 'Administrator']);

        // ユーザーに役割を割り当てる（role_user テーブルにデータを挿入）
        $user->roles()->attach(1, ['manager_id' => 999]); // role_id が 1 の役割と manager_id が 999 のマネージャーを割り当てる

        /** @var Authenticatable $user */
        // 認証済みのユーザーとしてアクセス
        $response = $this->actingAs($user)->get(route('admin'));

        // レスポンスのステータスコードが正しいことを確認
        $response->assertStatus(200);

        // ビューに 'users' 変数が渡されていることを確認
        $response->assertViewHas('users');
    }


    public function testMessagesSearch()
    {
        $item = Item::factory()->create(['name' => 'Test Item']); // テスト用の商品を作成
        $comment = Comment::factory()->create(['item_id' => $item->id]); // 商品に関連するコメントを作成
        $controller = new AdminController();
        $request = new Request(['item' => 'Test']); // 商品名でのリクエストをシミュレート
        $response = $controller->messages($request);
        $comments = $response->getData()['comments'];

        // フィルタリングされたコメントが正しい商品に関連していることを確認
        $this->assertTrue($comments->contains('item_id', $item->id));
    }
}
