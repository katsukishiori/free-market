<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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

    use RefreshDatabase;

    public function testMypage()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $condition = Condition::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $soldItem = SoldItem::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $profile = Profile::factory()->create(['user_id' => $user->id]);

        $response = $this->get('/mypage');

        $response->assertStatus(200);

        $response->assertViewIs('mypage');

        $response->assertViewHas('imgUrl', $profile->img_url);

        $response->assertViewHas('soldItems', function ($soldItems) use ($soldItem) {
            return $soldItems->contains($soldItem);
        });

        $response->assertViewHas('items', function ($items) use ($item) {
            return $items->contains($item);
        });
    }

    public function testUpdateProfile()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Auth::login($user);

        $file = File::create('avatar.jpg', 200, 200);

        $requestData = [
            'name' => 'New Name',
            'postcode' => '123-4567',
            'address' => 'New Address',
            'building' => 'New Building',
            'image' => $file,
        ];

        $this->assertNull($user->profile);

        $response = $this->post('/mypage/profile', $requestData);

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
        $user = User::factory()->create();
        Auth::login($user);

        $profile = Profile::factory()->create(['user_id' => $user->id]);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertViewIs('update_profile');

        // ビューに渡されたデータが正しいことを確認
        $response->assertViewHas('user', $user);
        $response->assertViewHas('profile', $profile);
        $response->assertViewHas('imgUrl', $profile->img_url);
    }

    public function testProfileWithNoProfile()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertViewIs('update_profile');

        $response->assertViewHas('user', $user);
        $response->assertViewHas('profile', null);
        $response->assertViewHas('imgUrl', 'default.jpg');
    }
}
