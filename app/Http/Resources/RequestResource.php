<?php

namespace App\Http\Resources;

use DateTime;
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

        $is_problematic = false;
        if ($this->start_date < new DateTime())
            foreach ($this->items as $item) {
                $itemRequest = $item->requests()
                    ->where(function ($query) {
                        $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                            ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                            ->orWhere(function ($query) {
                                $query->whereDate('start_date', '<', $this->start_date)
                                    ->whereDate('end_date', '>', $this->end_date);
                            });
                    })
                    ->selectRaw('SUM(amount) as amount')
                    ->groupBy('item_id', 'item_request.request_id', 'item_request.amount')
                    ->first();

                if ($itemRequest->amount > $item->amount) $is_problematic = true;
            }

        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'accepted' => $this->accepted,
            'request_name' => $this->request_name,
            'is_problematic' => $is_problematic
            // 'items' => $this->items->pluck('id'),
        ];
    }
}
