<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UniqueItem>
 */
class UniqueItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        echo ('.');
        return [
            'alt_name' => $this->faker->word(),
            // 'is_usable' => $this->faker->optional($weight = 0.8, $default = false)->boolean(),
            // 'hehe' => 'hehe'
        ];
    }
}
