<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request, $startDate = null, $endDate = null)
    {
        return [
            'id' => $this->id,
            'district' => $this->district,
            'category' => $this->category->category_name,
            'store' => $this->store_id,
            'owner' => $this->owner,
            'item_name' => $this->item_name,
            'amount' => $this->amount,
            'comment' => $this->comment,
            'in_store_amount' => $this->in_store_amount,
            'isSelected' => false,
            'selected_amount' => 0,
            'other_requests' => OtherRequestsForItemResource::collection($this->requests($startDate, $endDate))
        ];
    }
}
