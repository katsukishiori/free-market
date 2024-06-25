<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role' => $this->faker->randomElement(['admin', 'manager', 'user']), // 'admin', 'manager', 'user' のいずれかをランダムに選択
            'name' => $this->faker->unique()->word, // ユニークな単語を生成
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Role $role) {
            if ($role->role === 'admin') {
                $role->name = '管理者';
            } elseif ($role->role === 'manager') {
                $role->name = '店舗代表者';
            } elseif ($role->role === 'user') {
                $role->name = '利用者';
            }
            $role->save();
        });
    }
}
