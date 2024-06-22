<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Profile::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'postcode' => $this->faker->postcode,
            'address' => $this->faker->address,
            'building' => $this->faker->secondaryAddress,
            'img_url' => 'default.jpg',
        ];
    }
}
