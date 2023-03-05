<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TakeOutUniqueItemResource extends JsonResource
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
            'alt_name' => $this->alt_name,
        ];
    }
}