<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
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
        $stores = Store::select('id', 'district')->get();
        $store = $this->faker->randomElement($stores);
        $categories = Category::pluck('id')->toArray();
        $amount = $this->faker->numberBetween(1, 10);

        return [
            'category_id' => $this->faker->randomElement($categories),
            'store_id' => $store['id'],
            'item_name' => $this->faker->word(),
            'amount' => $amount,
            'is_unique' => $this->faker->optional($weight = 0.4, $default = false)->boolean(),
            'in_store_amount' => $amount
        ];
    }
}
