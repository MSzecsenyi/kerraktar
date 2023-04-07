<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory(10)->create([
            'district' => 5,
            'store_id' => 1,
        ]);
        Item::factory(6000)->create();
    }
}
