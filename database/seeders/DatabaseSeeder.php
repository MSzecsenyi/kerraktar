<?php

namespace Database\Seeders;

use App\Models\Group;
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
        ]);

        $stores = Store::all();

        // Populate the pivot table
        User::where('is_storekeeper','=','true')->each(function ($user) use ($stores) {
            $user->stores()->attach(
                $stores->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

    }
}
