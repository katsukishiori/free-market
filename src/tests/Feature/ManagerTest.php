<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Mail\InviteManagerMail;
use App\Models\User;
use App\Models\Manager;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class ManagerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    // クラスプロパティとして宣言
    protected $uniqueEmail;

    protected function setUp(): void
    {
        parent::setUp();

        // テストに必要なデータを作成
        Role::factory()->create([
            'id' => 2,
            'name' => 'manager',
            'role' => 'manager'
        ]);

        $this->uniqueEmail = 'manager_' . uniqid() . '@example.com';
    }

    public function testIndex()
    {
        // テストに必要なデータを作成
        $user = User::factory()->create([
            'email' => $this->uniqueEmail,
        ]);

        $manager = Manager::factory()->create();

        // ユーザーに役割を割り当てる（role_user テーブルにデータを挿入）
        $user->roles()->attach(2, ['manager_id' => $manager->id]);

        /** @var Authenticatable $user */
        // 認証済みのユーザーとしてアクセス
        $response = $this->actingAs($user)->get(route('manager'));

        // レスポンスのステータスコードが正しいことを確認
        $response->assertStatus(200);

        // ビューに 'users' 変数が渡されていることを確認
        $response->assertViewHas('users');
    }

    public function testSendInviteManagerEmail()
    {
        Mail::fake(); // メール送信をモック

        $user = User::factory()->create(); // ユーザーを作成

        // ログインしているユーザーとして振る舞う
        $this->actingAs($user);

        $data = [
            'email' => 'test@example.com',
        ];

        // 招待メール送信リクエストを送信
        $response = $this->post('/invited', $data);

        // ログ出力
        Log::info('Response status:', ['status' => $response->status()]);
        Log::info('Session data:', session()->all());

        // レスポンスを確認
        $response->assertRedirect()
            ->assertSessionHas('status', '招待メールを送信しました!');

        // メールが送信されたことを確認
        Mail::assertSent(InviteManagerMail::class, function ($mail) use ($data) {
            return $mail->hasTo($data['email']);
        });
    }
}
