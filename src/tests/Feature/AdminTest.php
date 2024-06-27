<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
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
        $user = User::factory()->create();
        $manager = Manager::factory()->create(['id' => 999]);

        Role::factory()->create(['id' => 1, 'name' => 'Administrator']);

        $user->roles()->attach(1, ['manager_id' => 999]);

        /** @var Authenticatable $user */

        $response = $this->actingAs($user)->get(route('admin'));

        $response->assertStatus(200);

        $response->assertViewHas('users');
    }


    public function testMessagesSearch()
    {
        $item = Item::factory()->create(['name' => 'Test Item']);
        $comment = Comment::factory()->create(['item_id' => $item->id]);
        $controller = new AdminController();
        $request = new Request(['item' => 'Test']);
        $response = $controller->messages($request);
        $comments = $response->getData()['comments'];

        $this->assertTrue($comments->contains('item_id', $item->id));
    }
}
