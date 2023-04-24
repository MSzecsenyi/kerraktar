<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Request;

class RequestDetailsItemsResource extends JsonResource
{
    private static $requestId;

    public static function customCollection($resource, $parentRequestId): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        self::$requestId = $parentRequestId;
        return parent::collection($resource);
    }

    public function toArray($request)
    {
        $attachedToRequest = Request::find(self::$requestId);
        $isSelected = $attachedToRequest->items->contains($this->id);
        $selectedAmount = $isSelected ? $attachedToRequest->items->where('id', $this->id)->first()->pivot->amount : 1;

        return [
            'id' => $this->id,
            // 'category' => $this->category->category_name,
            'item_name' => $this->item_name,
            'amount' => $this->amount,
            'is_selected' => $isSelected,
            'selected_amount' => $selectedAmount,
            'other_requests' => OtherRequestsForItemResource::collection($this->requests($attachedToRequest->start_date, $attachedToRequest->end_date, self::$requestId)),
        ];
    }
}
