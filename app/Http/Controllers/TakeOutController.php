<?php

namespace App\Http\Controllers;

use App\Http\Resources\TakeOutDetailedResource;
use App\Http\Resources\TakeOutResource;
use App\Models\Item;
use App\Models\TakeOut;
use App\Models\UniqueItem;
use Error;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;

class TakeOutController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->is_storekeeper) {
            $storeIds = $user->stores->pluck('id');
            $takeOuts = TakeOut::whereIn('store_id', $storeIds)->get();

            return TakeOutResource::collection($takeOuts);
        } else if ($user->is_group) {
            $takeOuts = $user->takeOuts;

            return TakeOutResource::collection($takeOuts);
        } else {
            return response()->json("Unauthorized request", 401);
        }
    }

    public function create(Request $request)
    {
        if (!auth()->user()->is_storekeeper && !auth()->user()->is_group) {
            return response()->json("Unauthorized request", 401);
        }

        $newTakeout = TakeOut::create([
            'start_date'        => now(),
            'end_date'          => null,
            'user_id'           => auth()->user()->id,
            'store_id'          => $request->store_id,
            'take_out_name'      => $request->take_out_name,
        ]);

        foreach ($request->items as $item) {
            $newTakeout->items()->attach([
                $item['id'] => ['amount' => $item['amount']]
            ]);
            error_log($item['amount']);
        }

        foreach ($request->uniqueItems as $uniqueItem) {

            $item = UniqueItem::find($uniqueItem)->item;
            $newTakeout->items()->syncWithoutDetaching([
                $item['id'] => ['amount' => -1]
            ]);

            $newTakeout->uniqueItems()->attach(
                $uniqueItem
            );
        }

        return response()->json($newTakeout, 201);
    }

    public function returnTakeOut(TakeOut $takeOut)
    {
        if (!auth()->user()->is_group) {
            return response()->json("Unauthorized request", 401);
        }

        // $record = TakeOut::findOrFail($takeOut)->where('user_id', auth()->user()->id)->where('end_date', null);
        $takeOut->update(['end_date' => now()]);

        return response()->json($takeOut, 200);
    }

    public function show(TakeOut $takeOut)
    {
        if (!auth()->user()->is_group && !auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        return response()->json(new TakeOutDetailedResource($takeOut), 200);
    }
}
