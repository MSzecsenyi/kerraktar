<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\Store;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->is_storekeeper && !auth()->user()->is_group){
            return response()->json("Unauthorized request", 401);
        }

        $category_id = $request->category_id;
        $district = $request->district;
        $store_id = $request->store_id;
        $item_name = $request->item_name;

        $items = Item::when($category_id, function ($query, $category_id){
            return $query->where('category_id', $category_id);
        })
        ->when($district, function ($query, $district){
            return $query->where('district', $district);
        })
        ->when($store_id, function ($query, $store_id){
            return $query->where('store_id', $store_id);
        })
        ->when($item_name, function ($query, $item_name){
            return $query->where('item_name','like','%'.$item_name.'%');
        })
        ->paginate(20);

        return ItemResource::collection($items);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(!auth()->user()->is_storekeeper && !auth()->user()->is_group){
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
        if(!auth()->user()->is_storekeeper){
            return response()->json("Unauthorized request", 401);
        }

        $category_ids = Category::all()->pluck('id')->toArray();
        $store_ids = Store::all()->pluck('id')->toArray();

        $request->validate([
            'district' => 'required|between:1,10||integer',
            'category_id' => 'required|in:'.implode(",", $category_ids),
            'store_id' => 'required|in:'.implode(",",$store_ids),
            'is_available' => 'boolean|nullable',
            'is_usable' => 'boolean|nullable',
            'owner' => 'max:128|nullable',
            'item_name' => 'required|max:128',
            'amount' => 'integer|nullable',
            'comment' => 'max:4096|nullable',
        ]);

        $item = Item::create($request->all());

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
        if(!auth()->user()->is_storekeeper){
            return response()->json("Unauthorized request", 401);
        }

        $category_ids = Category::all()->pluck('id')->toArray();
        $store_ids = Store::all()->pluck('id')->toArray();

        $request->validate([
            'district' => 'sometimes|between:1,10||integer',
            'category_id' => 'sometimes|in:'.implode(",", $category_ids),
            'store_id' => 'sometimes|in:'.implode(",",$store_ids),
            'is_available' => 'sometimes|boolean',
            'is_usable' => 'sometimes|boolean',
            'owner' => 'sometimes|max:128',
            'item_name' => 'sometimes|max:128',
            'amount' => 'sometimes|integer',
            'comment' => 'sometimes|max:4096',
        ]);

        $item->update($request->all());

        return response()->json(new ItemResource($item), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if(!auth()->user()->is_storekeeper){
            return response()->json("Unauthorized request", 401);
        }

        $item->delete();

        return response()->json(null, 204);
    }

    public function updateComment(Request $request, Item $item)
    {
        if(!auth()->user()->is_storekeeper && !auth()->user()->is_group){
            return response()->json("Unauthorized request", 401);
        }

        $item->update([
            'comment' => $request->comment
        ]);

        return response()->json(new ItemResource($item), 200);
    }
}
