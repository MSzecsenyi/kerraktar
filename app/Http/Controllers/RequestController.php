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
        if (!auth()->user()->is_group) {
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
        if ($user->is_group) {
            $requests = $user->requests;
        } else if ($user->is_storekeeper) {
            $storeIds = $user->stores->pluck('id');
            $requests = Request::whereIn('store_id', $storeIds)->get();
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
        $user = auth()->user();
        $request = Request::findOrFail($request->id);
        if (($user->is_storekeeper && $user->district == $request->store->district) || ($user->is_group && $request->user->id == $user->id)) {

            $request->items()->detach();

            foreach ($req->all() as $item) {
                error_log($item['id']);
                $request->items()->attach([$item['id'] => ['amount' => $item['amount']]]);
            }

            return RequestDetailsItemsResource::customCollection($request->store->items, $request->id);
        } else {
            return response()->json("Unauthorized request", 401);
        }
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();
        $request = Request::findOrFail($request->id);

        if (($user->is_storekeeper && $user->district == $request->store->district) || ($user->is_group && $request->user->id == $user->id)) {
            $request->items()->detach();
            $request->delete();
            return response()->json("Request deleted successfully", 200);
        } else {
            return response()->json("Unauthorized request", 401);
        }
    }
}
