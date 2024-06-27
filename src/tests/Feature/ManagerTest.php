<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use App\Models\Manager;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ManagerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

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

        $response = $this->get("/register/invited/{$token}");

        $response->assertStatus(302);
    }

    public function testUserRegistration()
    {
        $userData = [
            'name' => 'ユーザーA',
            'email' => 'usera@example.com',
            'password' => Hash::make('usera123'),
        ];

        DB::table('users')->insert($userData);

        $this->assertDatabaseHas('users', [
            'name' => 'ユーザーA',
            'email' => 'usera@example.com',
        ]);

        // 登録したユーザーのパスワードが正しいことをアサート
        $user = DB::table('users')->where('email', 'usera@example.com')->first();
        $this->assertTrue(Hash::check('usera123', $user->password));
    }
}
