<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Item;
use App\Models\SoldItem;
use App\Models\User;
use App\Models\Profile;
use App\Models\Condition;
use Illuminate\Http\Testing\File;


class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMypage()
    {
        // テストユーザーを作成し、ログイン
        $user = User::factory()->create();
        Auth::login($user);

        // Conditionを作成
        $condition = Condition::factory()->create();

        // Itemを作成
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        // SoldItemを作成
        $soldItem = SoldItem::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // プロフィールを作成
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        // マイページにアクセス
        $response = $this->get('/mypage');

        // ステータスコードが200であることを確認
        $response->assertStatus(200);

        // 正しいビューが返されていることを確認
        $response->assertViewIs('mypage');

        // imgUrlが正しいことを確認
        $response->assertViewHas('imgUrl', $profile->img_url);

        // soldItemsにsoldItemが含まれていることを確認
        $response->assertViewHas('soldItems', function ($soldItems) use ($soldItem) {
            return $soldItems->contains($soldItem);
        });

        // itemsにitemが含まれていることを確認
        $response->assertViewHas('items', function ($items) use ($item) {
            return $items->contains($item);
        });
    }

    public function testUpdateProfile()
    {
        // モックストレージを設定
        Storage::fake('public');

        // テストユーザーを作成し、ログイン
        $user = User::factory()->create();
        Auth::login($user);

        // ダミーの画像ファイルを作成
        $file = File::create('avatar.jpg', 200, 200);

        // リクエストデータを作成
        $requestData = [
            'name' => 'New Name',
            'postcode' => '123-4567',
            'address' => 'New Address',
            'building' => 'New Building',
            'image' => $file,
        ];

        // 更新前のプロフィールを確認
        $this->assertNull($user->profile);

        // プロフィール更新リクエストを送信
        $response = $this->post('/mypage/profile', $requestData);

        // リダイレクト先とセッションメッセージを確認
        $response->assertRedirect();
        $response->assertSessionHas('success', 'プロフィールが更新されました！');

        // 更新後のユーザー名を確認
        $this->assertEquals('New Name', $user->fresh()->name);

        // 更新後のプロフィールを確認
        $profile = $user->fresh()->profile;
        $this->assertNotNull($profile);
        $this->assertEquals('123-4567', $profile->postcode);
        $this->assertEquals('New Address', $profile->address);
        $this->assertEquals('New Building', $profile->building);
    }

    public function testProfile()
    {
        // テストユーザーを作成し、ログイン
        $user = User::factory()->create();
        Auth::login($user);

        // プロフィールを作成し、ユーザーに関連付け
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        // プロフィールページにアクセス
        $response = $this->get('/mypage/profile');

        // ステータスコードが200であることを確認
        $response->assertStatus(200);

        // 正しいビューが返されていることを確認
        $response->assertViewIs('update_profile');

        // ビューに渡されたデータが正しいことを確認
        $response->assertViewHas('user', $user);
        $response->assertViewHas('profile', $profile);
        $response->assertViewHas('imgUrl', $profile->img_url);
    }

    public function testProfileWithNoProfile()
    {
        // プロフィールがないユーザーを作成し、ログイン
        $user = User::factory()->create();
        Auth::login($user);

        // プロフィールページにアクセス
        $response = $this->get('/mypage/profile');

        // ステータスコードが200であることを確認
        $response->assertStatus(200);

        // 正しいビューが返されていることを確認
        $response->assertViewIs('update_profile');

        // ビューに渡されたデータが正しいことを確認
        $response->assertViewHas('user', $user);
        $response->assertViewHas('profile', null);
        $response->assertViewHas('imgUrl', 'default.jpg');
    }
}
