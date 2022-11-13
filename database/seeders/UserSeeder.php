<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => "admin",
            'email' => "admin@nn.nn",
            'email_verified_at' => now(),
            'password' => 'pw', // password
            'remember_token' => Str::random(10),
            'district' => 5,
            'group_number' => 519,
            'phone' => +131323,
            'is_group' => false,
            'is_storekeeper' => true,
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => "raktaros",
            'email' => "raktaros@nn.nn",
            'email_verified_at' => now(),
            'password' => 'pw', // password
            'remember_token' => Str::random(10),
            'district' => 5,
            'group_number' => 519,
            'phone' => +131323,
            'is_group' => false,
            'is_storekeeper' => true,
            'is_admin' => false,
        ]);

        User::factory()->create([
            'name' => "csapat",
            'email' => "csapat@nn.nn",
            'email_verified_at' => now(),
            'password' => 'pw', // password
            'remember_token' => Str::random(10),
            'district' => 5,
            'group_number' => 519,
            'phone' => +131323,
            'is_group' => true,
            'is_storekeeper' => false,
            'is_admin' => false,
        ]);



        User::factory(10)->create();
    }
}
