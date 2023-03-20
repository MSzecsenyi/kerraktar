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

        $is_conflicted = false;
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

                if ($itemRequest->amount > $item->amount) $is_conflicted = true;
            }

        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'user' => $this->user->user->group_number,
            'store' => $this->store->address,
            'request_name' => $this->request_name,
            'is_conflicted' => $is_conflicted
            // 'items' => $this->items->pluck('id'),
        ];
    }
}
