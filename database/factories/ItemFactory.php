<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Group;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

        return [
            'district' => $store['district'],
            'category_id' => $this->faker->randomElement($categories),
            'store_id' => $store['id'],
            'is_available' => $this->faker->boolean(70),
            'is_usable' => $this->faker->boolean(90),
            'owner' => $this->faker->sentence(3), // not relevant field, some districts might need it
            'item_name' => $this->faker->word(),
            'amount' => $this->faker->numberBetween(1,50),
            'comment' => $this->faker->text(50),
        ];
    }
}
