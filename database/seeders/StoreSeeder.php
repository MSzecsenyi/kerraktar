<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = Store::factory()->create([
            'address' => "Kerraktár 5. ker",
            'district' => 5,
        ]);

        $users = \App\Models\User::query()->whereIn('id', [1, 2, 3])->get();
        $users->each(function ($user) use ($store) {
            $user->stores()->attach($store);
        });

        Store::factory(30)->create();
    }
}
