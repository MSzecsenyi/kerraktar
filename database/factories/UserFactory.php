<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_group = $this->faker->boolean(70);
        $is_storekeeper = !$is_group;
        $is_group ? $is_admin = false : $is_admin = $this->faker->boolean(30);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'district' => $this->faker->numberBetween(1, 10),
            'group_number' => $this->faker->numberBetween(1, 2000),
            'phone' => $this->faker->e164PhoneNumber(),
            'is_group' => $is_group,
            'is_storekeeper' => $is_storekeeper,
            'is_admin' => $is_admin,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
