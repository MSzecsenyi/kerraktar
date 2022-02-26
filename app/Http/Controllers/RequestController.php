<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestResource;
use App\Models\Item;
use App\Models\Request;
use App\Models\User;
use Illuminate\Http\Request as RouteRequest;
use Illuminate\Routing\Router;

class RequestController extends Controller
{
    public function store(RouteRequest $req)
    {
        User::findOrFail($req->user_id)->where('is_group',true)->get();

        $newRequest = Request::create([
            'user_id'       => $req->user_id,
            'start_date'    => $req->start_date,
            'end_date'      => $req->end_date
        ]);

        $itemIds = $req->itemIds;
        $newRequest->items()->sync($itemIds);
        return response()->json($newRequest, 201);
    }

    public function acceptRequest(RouteRequest $req, Request $request)
    {
        $request->accepted = $req->accepted;
        $request->save();
        return response()->json($request, 200);
    }

    public function index()
    {
        return RequestResource::collection(Request::all());
    }

    public function show(Request $request)
    {
        return new RequestResource($request);
    }

    public function update(RouteRequest $req, Request $request)
    {
        User::findOrFail($request->user_id)->where('is_group',true)->get();

        $request->update($req->all());
        $itemIds = $req->itemIds;
        $request->items()->sync($itemIds);
        return response()->json(new RequestResource($request, 200));
    }

    public function takeout(Request $request)
    {
        $request->is_out = true;
        $request->save();
    }

    public function giveback(Request $request)
    {
        $request->is_out = false;
        $request->is_completed = true;
        $request->save();
    }

}
