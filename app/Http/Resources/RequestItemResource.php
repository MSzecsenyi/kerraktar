<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestItemResource extends JsonResource
{
    private static $startDate;
    private static $endDate;

    public static function customCollection($resource, $startDate, $endDate): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        self::$startDate = $startDate;
        self::$endDate = $endDate;
        return parent::collection($resource);
    }

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
            'category' => $this->category->category_name,
            'item_name' => $this->item_name,
            'amount' => $this->amount,
            'in_store_amount' => $this->in_store_amount,
            'isSelected' => false,
            'selected_amount' => 1,
            'other_requests' => OtherRequestsForItemResource::collection($this->requests(self::$startDate, self::$endDate))
        ];
    }
}
