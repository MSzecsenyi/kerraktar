<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'district' => $this->faker->randomDigitNot(6)+1,
            'name' => $this->faker->name() . "cscs.",
            'number' => $this->faker->unique()->numberBetween(1,2000),
            'leader' => $this->faker->name(),
            'phone' => $this->faker->e164PhoneNumber(),
        ];
    }
}
