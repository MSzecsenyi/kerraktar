<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Http\Resources\RequestItemResource;
use App\Http\Resources\ItemTakeOutResource;
use App\Http\Resources\TakeOutResource;
use App\Models\Item;
use App\Models\UniqueItem;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->is_storekeeper && !auth()->user()->is_group) {
            return response()->json("Unauthorized request", 401);
        }

        $category_id = json_decode($request->category_id);
        $store_id = json_decode($request->store_id);
        $item_name = $request->item_name;

        $items = Item::when($category_id, function ($query, $category_id) {
            return $query->whereIn('category_id', $category_id);
        })
            ->when($store_id, function ($query, $store_id) {
                return $query->whereIn('store_id', $store_id);
            })
            ->when($item_name, function ($query, $item_name) {
                return $query->where('item_name', 'like', '%' . $item_name . '%');
            })->get();
        // ->paginate(20);

        return ItemResource::collection($items);
    }

    public function index_for_requests(Request $request)
    {
        if (!auth()->user()->is_storekeeper && !auth()->user()->is_group) {
            return response()->json("Unauthorized request", 401);
        }

        $category_id = json_decode($request->category_id);
        $store_id = json_decode($request->store_id);
        $item_name = $request->item_name;

        $items = Item::when($category_id, function ($query, $category_id) {
            return $query->whereIn('category_id', $category_id);
        })
            ->when($store_id, function ($query, $store_id) {
                return $query->whereIn('store_id', $store_id);
            })
            ->when($item_name, function ($query, $item_name) {
                return $query->where('item_name', 'like', '%' . $item_name . '%');
            })->get();
        // ->paginate(20);

        return RequestItemResource::customCollection($items, $request->startDate, $request->endDate);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!auth()->user()->is_storekeeper && !auth()->user()->is_group) {
            return response()->json("Unauthorized request", 401);
        }

        $items = Item::whereIn('id', $request->ids)->get();

        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        $item = Item::create([
            'category_id' => $request->input('category_id'),
            'store_id' => $request->input('store_id'),
            'item_name' => $request->input('item_name'),
            'amount' => $request->input('amount'),
            'in_store_amount' => $request->input('amount'),
            'is_unique' => $request->input('is_unique'),
        ]);

        if ($item->is_unique) {
            foreach ($request->input('unique_items') as $uniqueItem) {
                $newUniqueItem = new UniqueItem($uniqueItem);
                $newUniqueItem->item()->associate($item);
                $newUniqueItem->save();
            }
        }

        return response()->json(new ItemResource($item), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if (!auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        $item = Item::findOrFail($request->input('id'));
        $item->update([
            'category_id' => $request->input('category_id'),
            'item_name' => $request->input('item_name'),
            'amount' => $request->input('amount'),
            'in_store_amount' => $item->in_store_amount + $request->input('amount') - $item->amount,
            'is_unique' => $request->input('is_unique'),
        ]);

        $existingUniqueItems = $item->uniqueItems;
        $requestUniqueItems = collect($request->input('unique_items'));

        // Get the IDs of the unique items in the request
        $requestUniqueItemIds = $requestUniqueItems->pluck('id')->filter();

        // Find the unique items in $existingUniqueItems that are not in $requestUniqueItems
        $itemsToDelete = $existingUniqueItems->filter(function ($existingUniqueItem) use ($requestUniqueItemIds) {
            return !$requestUniqueItemIds->contains($existingUniqueItem->id);
        });

        // Delete the found unique items
        foreach ($itemsToDelete as $itemToDelete) {
            $itemToDelete->delete();
        }
        if ($item->is_unique) {
            foreach ($request->input('unique_items') as $uniqueItem) {
                if ($uniqueItem['id']) {
                    $existingUniqueItem = UniqueItem::findOrFail($uniqueItem['id']);
                    $existingUniqueItem->update($uniqueItem);
                } else {
                    $newUniqueItem = new UniqueItem($uniqueItem);
                    $newUniqueItem->item()->associate($item);
                    $newUniqueItem->save();
                }
            }
        }

        $item = Item::findOrFail($request->input('id'));

        return response()->json(new ItemResource($item), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if (!auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        $item->uniqueItems()->delete();
        $item->delete();

        return response()->json(null, 204);
    }

    public function getUuids()
    {
        $uuids = UniqueItem::all()->pluck('uuid')->toArray();
        return response()->json($uuids);
    }

    public function history(Item $item)
    {
        if (!auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        return ItemTakeOutResource::collection($item->takeOuts);
    }

    public function uniqueItemHistory(UniqueItem $uniqueItem)
    {
        if (!auth()->user()->is_storekeeper) {
            return response()->json("Unauthorized request", 401);
        }

        return TakeOutResource::collection($uniqueItem->takeOuts);
    }
}
