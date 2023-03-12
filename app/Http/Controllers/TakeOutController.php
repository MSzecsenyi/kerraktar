<?php

namespace App\Http\Controllers;

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
        if (!auth()->user()->is_storekeeper && !auth()->user()->is_group) {
            return response()->json("Unauthorized request", 401);
        }

        // Request options:
        // select takeouts made from a specific store
        // select takeouts made by a specific user
        // display all / active takeouts
        $store_id = json_decode($request->store_id);
        $user_id = json_decode($request->group_id);
        $only_current = json_decode($request->only_current);

        $takeOuts = TakeOut::when($user_id, function ($query, $user_id) {
            return $query->whereIn('user_id', $user_id);
        })
            ->when($store_id, function ($query, $store_id) {
                return $query->whereIn('store_id', $store_id);
            })
            ->when($only_current, function ($query) {
                return $query->where('end_date', null);
            })
            ->get();

        return response()->json($takeOuts, 200);
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
        }

        foreach ($request->uniqueItems as $uniqueItem) {

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
        if (!auth()->user()->is_group && !auth()->user()->is_group) {
            return response()->json("Unauthorized request", 401);
        }

        return response()->json(new TakeOutResource($takeOut), 200);
    }
}
