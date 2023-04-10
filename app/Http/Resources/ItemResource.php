<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->is_unique) {
            return [
                'id' => $this->id,
                'category' => $this->category ? $this->category->category_name : "none",
                'item_name' => $this->item_name,
                'amount' => $this->amount,
                'is_unique' => $this->is_unique,
                'in_store_amount' => $this->in_store_amount,
                'unique_items' => UniqueItemResource::collection($this->uniqueItems),
                'isSelected' => false,
                'selected_amount' => 0,
                'selected_unique_items' => []
            ];
        } else {
            return [
                'id' => $this->id,
                'category' => $this->category ? $this->category->category_name : "none",
                'item_name' => $this->item_name,
                'amount' => $this->amount,
                'is_unique' => $this->is_unique,
                'in_store_amount' => $this->in_store_amount,
                'unique_items' => [],
                'isSelected' => false,
                'selected_amount' => 1,
                'selected_unique_items' => []
            ];
        }
    }
}
