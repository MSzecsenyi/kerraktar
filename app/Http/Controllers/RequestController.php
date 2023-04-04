<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestResource;
use App\Http\Resources\RequestDetailsItemsResource;
use App\Models\Request;
use App\Models\User;
use Illuminate\Http\Request as RouteRequest;

class RequestController extends Controller
{
    public function create(RouteRequest $req)
    {
        if (!auth()->user()->is_storekeeper && !auth()->user()->is_group) {
            return response()->json("Unauthorized request", 401);
        }

        $newRequest = Request::create([
            'user_id'       => auth()->user()->id,
            'start_date'    => $req->start_date,
            'end_date'      => $req->end_date,
            'store_id'      => $req->store_id,
            'request_name'  => $req->request_name,
        ]);


        foreach ($req->items as $item) {
            $newRequest->items()->attach([
                $item['id'] => ['amount' => $item['amount']]
            ]);
        }

        return response()->json($newRequest, 201);
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->is_storekeeper) {
            $storeIds = $user->stores->pluck('id');
            $requests = Request::whereIn('store_id', $storeIds)->get();
        } else if ($user->is_group) {
            $requests = $user->requests;
        } else {
            return response()->json("Unauthorized request", 401);
        }

        return RequestResource::collection($requests);
    }

    public function show(Request $request)
    {
        return RequestDetailsItemsResource::customCollection($request->store->items, $request->id);
    }

    public function update(RouteRequest $req, Request $request)
    {
        User::findOrFail($request->user_id)->where('is_group', true)->get();

        $request->update($req->all());
        $itemIds = $req->itemIds;
        $request->items()->sync($itemIds);
        return response()->json(new RequestResource($request, 200));
    }
}
