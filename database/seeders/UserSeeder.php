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
            'email' => "szecsenyi.marton@cserkesz.hu",
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'group_id' => 1,
            'phone' => +131323,
            'is_group' => false,
            'is_storekeeper' => true,
            'is_admin' => true,
        ]);

        User::factory(10)->create();
    }
}
