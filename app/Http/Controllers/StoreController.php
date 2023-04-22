<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Resources\StoreResource;
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
        $stores = Store::query()
            ->withCount(['items as items'])
            ->with(['users' => function ($query) {
                $query->pluck('name');
            }])
            ->orderBy('district')
            ->orderBy('address')
            ->paginate(30);

        $storekeepers = User::where('is_storekeeper', true)->select('id', 'name', 'district')->get();

        return view('stores', compact('stores', 'storekeepers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        if (!auth()->user()->is_admin) {
            return response()->json("Unauthorized request", 401);
        }

        return new StoreResource($store);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStoreRequest $request)
    {
        error_log($request->storekeepers[0]);
        dd($request->all());
        $request->validate(['storekeepers']);
        $store = Store::create([
            'district' => $request->validated('district'),
            'address' => $request->validated('address'),
        ]);

        foreach ($request->storekeepers as $storekeeperId) {
            error_log($storekeeperId);
            try {
                $store->users()->attach($storekeeperId);
            } catch (\Exception $e) {
                error_log($e);
            }
        }

        return redirect()->route('stores');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        $store->items()->delete();
        $store->delete();

        return redirect()->route('stores');
    }

    /**
     * Add a storekeeper to a specific store
     *
     * @return \Illuminate\Http\Response
     */
    public function addStorekeeper(Request $request)
    {
        if (!auth()->user()->is_admin) {
            return response()->json("Unauthorized request", 401);
        }

        $user = User::findOrFail($request->userId);
        $store = Store::findOrFail($request->storeId);

        if (!$user->isStorekeeper()) {
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
        if (!auth()->user()->is_admin) {
            return response()->json("Unauthorized request", 401);
        }

        $user = User::findOrFail($request->userId);
        $store = Store::findOrFail($request->storeId);

        if (!in_array($user->id, $store->users()->pluck('users.id')->toArray())) {
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
        if (!auth()->user()->is_admin) {
            return response()->json("Unauthorized request", 401);
        }


        $originalStore = Store::findOrFail($request->originalStoreId);
        // error_log($originalStore->items()->pluck('id')->toArray()[1]);
        // $destinationStore = Store::find($request->destinationStoreId);

        foreach ($originalStore->items()->pluck('id')->toArray() as $itemId) {
            $item = Item::find($itemId);
            $item->store_id = $request->destinationStoreId;
            $item->save();
        }

        return response()->json($originalStore, 200);
    }
}
