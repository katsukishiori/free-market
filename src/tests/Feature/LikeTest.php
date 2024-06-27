<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

    use RefreshDatabase;

    public function testCreateLike()
    {
        /** @var Authenticatable $user */

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        // POSTリクエストを送信していいねを付ける
        $response = $this->post(route('like', ['item_id' => $item->id]));

        $response->assertRedirect();

        $this->assertTrue(session()->has('success'));
        $this->assertEquals('いいねしました！', session('success'));
    }

    public function testDeleteLike()
    {
        /** @var Authenticatable $user */

        $user = User::factory()->create();

        $this->actingAs($user);

        // テスト用のアイテムといいねを作成する
        $item = Item::factory()->create();
        $like = Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->post(route('unlike', ['item_id' => $item->id]));

        $response->assertRedirect();
    }
}
