<?php

namespace Database\Factories;

use App\Models\Invite;
use Illuminate\Database\Eloquent\Factories\Factory;

class InviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Invite::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory()->create()->id,
            'email' => $this->faker->unique()->safeEmail,
            'token' => \Illuminate\Support\Str::random(60),
        ];
    }
}
