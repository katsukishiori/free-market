<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 10000),
            'user_id' => \App\Models\User::factory(), // ここでユーザーファクトリーを使います
            'condition_id' => 1,
            'img_url' => 'default.jpg',
        ];
    }
}
