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
        return[
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'district' => $this->district,
            'category' => new CategoryResource($this->category),
            'store' => new StoreResource($this->store),
            'is_available' => $this->is_available,
            'is_usable' => $this->is_usable,
            'owner' => $this->owner,
            'item_name' => $this->item_name,
            'amount' => $this->amount,
            'comment' => $this->comment,
            'inavailable' => InavailableItemResource::collection($this->requests)
        ];
    }
}
