<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            StoreSeeder::class,
            CategorySeeder::class,
            ItemSeeder::class,
            UniqueItemSeeder::class
        ]);

        $stores = Store::all();

        // Populate the pivot table
        User::where('is_storekeeper', '=', 'true')->each(function ($user) use ($stores) {
            $stores = Store::where('district', $user->district)
                ->where('id', '>', $user->id < 4 ? 1 : 0) // only stores with id > 1 for users with id < 3
                ->get();
            $user->stores()->attach(
                $stores->random(rand(1, count($stores)))
                    ->pluck('id')->toArray()
            );
        });
    }
}
