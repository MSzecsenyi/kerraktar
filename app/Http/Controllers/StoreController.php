<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Resources\StoreResource;
use App\Imports\ItemImport;
use App\Models\Item;
use App\Models\Store;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        DB::beginTransaction();
        // dd($request->all());
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

        $tempFile = TemporaryFile::where('folder', $request->excelItems)->first();
        if ($tempFile) {
            Excel::import(new ItemImport(), storage_path('app/tmp/' . $request->excelItems . '/' . $tempFile->filename));
        }
        DB::commit();

        return redirect()->route('stores');
    }

    public function update(Request $request, Store $store)
    {
        $this->validate($request, [
            'selectedStorekeepers' => 'array',
            'selectedStorekeepers.*' => 'exists:users,id',
        ]);

        $selectedStorekeepers = $request->input('selectedStorekeepers', []);

        $store->users()->sync($selectedStorekeepers);

        return redirect()->back()->with('success', 'Users have been updated.');
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
