<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Request;

class RequestDetailsItemsResource extends JsonResource
{

    public function toArray($request)
    {
        // error_log($this->endDate);
        // $attachedToRequest = Request::find($this->requestId);

        return [
            'id' => $this->id,
            'category' => $this->category->category_name,
            'item_name' => $this->item_name,
            'amount' => $this->amount,
            // 'isSelected' => $attachedToRequest->items->contains($this),
            'selected_amount' => 0,
            'other_requests' => OtherRequestsForItemResource::collection($this->requests($this->startDate, $this->endDate))
        ];
    }
}