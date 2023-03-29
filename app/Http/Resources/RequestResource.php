<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\Models\Request;
use Carbon\Carbon;

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
        $currentDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        if ($currentDate->gte(now()->modify('-3 days'))){
            while($currentDate->lte($endDate) && !$is_conflicted){
            $items = $this->items()->pluck('item_id')->toArray();
            // Query all requests that are active on the current day
            $conflictingRequests = Request::where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->pluck('id');

            foreach($this->items as $item){
                $itemAmount = DB::table('item_request')
                    ->whereIn('request_id', $conflictingRequests)
                    ->where('item_id', $item->id)
                    ->sum('amount');

                if($itemAmount > $item->amount) $is_conflicted = true;
            }
            $currentDate->modify('+1 day');
        }
        }
        

        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'user' => $this->user->group_number,
            'store' => $this->store->address,
            'request_name' => $this->request_name,
            'is_conflicted' => $is_conflicted
        ];
    }
}
