<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TakeOutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'take_out_name' => $this->take_out_name,
            'user' => $this->user->name,
            'store' => $this->store_id,
            // 'items' => TakeOutItemResource::collection($this->items),
        ];
    }
}
