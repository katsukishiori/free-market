<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\Category;
use App\Models\CategoryItem;

class CategoryItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Item モデルと Category モデルからランダムなインスタンスを取得
        $item = Item::factory()->create();
        $category = Category::factory()->create();

        return [
            'item_id' => $item->id,
            'category_id' => $category->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
