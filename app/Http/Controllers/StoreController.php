<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResource;
use App\Models\Category;
use App\Models\Item;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StoreResource::collection(Store::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        return new StoreResource($store);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'district' => 'required|between:1,10||integer',
            'address' => 'required|min:10|max:256'
        ]);

        $store = Store::create($request->all());

        return response()->json($store, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        $store->delete();

        return response()->json(null, 204);
    }

    /**
     * Add a storekeeper to a specific store
     *
     * @return \Illuminate\Http\Response
     */
    public function addStorekeeper(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $store = Store::findOrFail($request->storeId);

        if(!$user->isStorekeeper()){
        return response()->json(['message' => 'Bad request - requested user is not a storekeeper'], 400);
        }

        $store->users()->attach($user);

        return response()->json($store, 204);
    }

    /**
     * Delete a storekeeper from a specific store
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteStorekeeper(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $store = Store::findOrFail($request->storeId);

        if(!in_array($user->id,$store->users()->pluck('users.id')->toArray())){
        return response()->json(['message' => 'Bad request - requested user is not a storekeeper of the specified store'], 400);
        }

        $store->users()->detach($user);

        return response()->json(null, 204);
    }

    /**
     * Migrate all items from a store
     *
     * @return \Illuminate\Http\Response
     */
    public function migrateItems(Request $request)
    {
        $originalStore = Store::findOrFail($request->originalStoreId);
        // error_log($originalStore->items()->pluck('id')->toArray()[1]);
        // $destinationStore = Store::find($request->destinationStoreId);

        foreach ($originalStore->items()->pluck('id')->toArray() as $itemId){
            $item = Item::find($itemId);
            $item->store_id = $request->destinationStoreId;
            $item->save();
        }

        return response()->json($originalStore, 200);
    }
}


