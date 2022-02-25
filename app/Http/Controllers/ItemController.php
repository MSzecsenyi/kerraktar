<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\Store;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ItemResource::collection(Item::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return response()->json($item, 201);
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

        return response()->json($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json(null, 204);
    }
}
