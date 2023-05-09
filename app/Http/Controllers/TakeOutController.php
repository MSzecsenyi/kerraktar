<?php

namespace App\Http\Controllers;

use App\Http\Resources\TakeOutDetailedResource;
use App\Http\Resources\TakeOutResource;
use App\Models\Item;
use App\Models\TakeOut;
use App\Models\UniqueItem;
use Error;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        foreach ($request->items as $item) {
            $inStoreAmount = Item::find($item['id'])->in_store_amount;

            if ($inStoreAmount < $item['amount']) {
                return response()->json("Insufficient in-store amount for item with id " . $item['id'], 400);
            }
        }

        foreach ($request->uniqueItems as $uniqueItem) {
            $uItem = UniqueItem::where('uuid', $uniqueItem)->first();

            if (!$uItem || $uItem->taken_out_by !== null) {
                return response()->json("Invalid unique item with uuid " . $uniqueItem, 400);
            }
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
            Item::find($item['id'])->decrement('in_store_amount', $item['amount']);
        }

        foreach ($request->uniqueItems as $uniqueItem) {
            $uItem = UniqueItem::where('uuid', $uniqueItem)->first();
            $item = $uItem->item;
            $newTakeout->items()->syncWithoutDetaching([
                $item['id'] => ['amount' => -1]
            ]);
            $item->decrement('in_store_amount', 1);

            $uItem->taken_out_by = auth()->user()->id;
            $uItem->save();

            $newTakeout->uniqueItems()->attach(
                $uItem
            );
        }
        return response()->json($newTakeout, 201);
    }

    public function returnTakeOut(TakeOut $takeOut)
    {
        if (!auth()->user()->is_group && !auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        if (!is_null($takeOut->end_date)) {
            return response()->json("already returned item", 400);
        }

        DB::beginTransaction();
        try {
            $takeOut->update(['end_date' => now()]);

            foreach ($takeOut->items as $item) {
                $item = Item::find($item->id);
                $pivot = $takeOut->items()->where('item_id', $item->id)->first()->pivot;
                if (!$item->is_unique) {
                    error_log($item->item_name);
                    error_log($item->in_store_amount);
                    error_log($pivot->amount);
                    $item->increment('in_store_amount', $pivot->amount);
                }
            }

            foreach ($takeOut->uniqueItems as $uniqueItem) {
                $uniqueItem->update(['taken_out_by' => null]);
                $item = $uniqueItem->item;
                $item->increment('in_store_amount');
                $uniqueItem->save();
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return response("error during db transaction", 500);
        }
        return response()->json($takeOut, 200);
    }

    public function show(TakeOut $takeOut)
    {
        if (!auth()->user()->is_group && !auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        return response()->json(new TakeOutDetailedResource($takeOut), 200);
    }

    public function showInStoreAmounts(TakeOut $takeOut)
    {
        if (!auth()->user()->is_group && !auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        return response()->json(new TakeOutDetailedResource($takeOut), 200);
    }
}
