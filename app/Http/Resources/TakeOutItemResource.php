<?php

namespace App\Http\Resources;

use App\Models\Item;
use App\Models\UniqueItem;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class TakeOutItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->pivot->amount != -1) {
            return [
                'id' => $this->id,
                'name' => $this->item_name,
                'amount' => $this->pivot->amount,
                'unique_items' => [],
            ];
        } else {
            $uniqueItemIds = $this->uniqueItems()
                ->whereHas('takeOuts', function ($query) {
                    $query->where('take_out_id', $this->pivot->take_out_id);
                })
                ->pluck('id');

            $uniqueItems = UniqueItem::whereIn('id', $uniqueItemIds)->get();

            return [
                'id' => $this->id,
                'name' => $this->item_name,
                'unique_items' => TakeOutUniqueItemResource::collection($uniqueItems),
            ];
        }
    }
}
