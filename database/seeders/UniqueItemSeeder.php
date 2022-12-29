<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\UniqueItem;
use Illuminate\Database\Seeder;

class UniqueItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::where('is_unique', true)->get();

        foreach ($items as $item) {
            for ($i = 0; $i < $item->amount; $i++)
                UniqueItem::factory()->create([
                    'item_id' => $item->id
                ]);
        }
    }
}
