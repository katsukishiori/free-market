<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;


class PurchaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function testIndex()
    {
        $item = Item::factory()->create();

        $response = $this->get("/purchase/{$item->id}");

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function testPurchase()
    {
        /** @var Authenticatable $user */
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->artisan('migrate');

        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
        ]);

        $response->assertRedirect('/mypage');

        $this->assertDatabaseHas('sold_item', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }

    public function testAddress()
    {
        $item = Item::factory()->create();

        /** @var Authenticatable $user */

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get("/purchase/address/{$item->id}");

        $response->assertStatus(200);
    }

    public function testUpdateAddress()
    {
        $item = Item::factory()->create();

        /** @var Authenticatable $user */

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('update.address', ['item_id' => $item->id]));

        $response->assertStatus(200);
    }
}
