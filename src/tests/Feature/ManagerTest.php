<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Mail\InviteManagerMail;
use App\Models\User;
use App\Models\Manager;
use App\Models\Role;


use Illuminate\Support\Str;

class ManagerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    protected $uniqueEmail;

    protected function setUp(): void
    {
        parent::setUp();

        Role::factory()->create([
            'id' => 2,
            'name' => 'manager',
            'role' => 'manager'
        ]);

        $this->uniqueEmail = 'manager_' . uniqid() . '@example.com';
    }

    public function testIndex()
    {
        $user = User::factory()->create([
            'email' => $this->uniqueEmail,
        ]);

        $manager = Manager::factory()->create();

        $user->roles()->attach(2, ['manager_id' => $manager->id]);

        /** @var Authenticatable $user */

        $response = $this->actingAs($user)->get(route('manager'));

        $response->assertStatus(200);

        $response->assertViewHas('users');
    }


    public function testShowInvitedUserRegistrationForm()
    {
        $token = Str::random(60);

        // テスト対象のメソッドを実行する
        $response = $this->get("/register/invited/{$token}");

        $response->assertStatus(302);
    }






    public function testRegisterInvitedUser()
    {
        Role::create(['name' => 'manager', 'role' => 2]);

        $user = User::factory()->create();

        $token = Str::random(60);

        Manager::create([
            'user_id' => $user->id,
            'email' => 'invited@example.com',
            'token' => $token,
        ]);

        $requestData = [
            'shop_name' => 'Test Shop',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // テスト対象のメソッドを実行する
        $response = $this->post(route('register.invited.post', $token), $requestData);

        // ユーザーが正しく作成されたことをアサートする
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));

        // Manager が正しく作成されたことをアサートする
        $this->assertDatabaseHas('managers', [
            'shop_name' => 'Test Shop',
            'user_id' => $user->id,
        ]);

        // ロールが正しく関連付けられていることをアサートする
        $role = Role::where('name', 'manager')->first();
        $this->assertTrue($user->roles->contains($role));

        $response->assertSessionHas('success', '登録されました！');

        $response->assertViewIs('auth.register_invited');
    }
}
