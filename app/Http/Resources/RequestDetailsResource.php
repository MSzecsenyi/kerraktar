<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class RequestDetailsResource extends JsonResource
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
            'user' => $this->user->group_number,
            'store' => $this->store->address,
            'request_name' => $this->request_name,
            'is_conflicted' => false,
            'items' => RequestDetailsItemsResource::collection($this->store->items, $this->id, $this->start_date, $this->end_date),
        ];
    }
}
