<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OtherRequestsForItemResource extends JsonResource
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'amount' => $this->pivot->amount,
            'user' => $this->user->group_number,
        ];
    }
}
