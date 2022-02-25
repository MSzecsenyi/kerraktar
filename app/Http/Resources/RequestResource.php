<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'accepted' => $this->accepted,
            'is_out' => $this->is_out,
            'is_completed' => $this->is_completed,
            'user' => $this->user,
            'items' => ItemResource::collection($this->items)
        ];
    }
}
