<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'item_id' => \App\Models\Item::factory(),
            'comment' => $this->faker->sentence,
        ];
    }
}
