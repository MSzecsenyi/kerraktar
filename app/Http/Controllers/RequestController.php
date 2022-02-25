<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Request;
use App\Models\User;
use Illuminate\Http\Request as RouteRequest;

class RequestController extends Controller
{
    public function store(RouteRequest $request)
    {
        User::findOrFail($request->user_id)->where('is_group',true)->get();

        $newRequest = Request::create([
            'user_id'       => $request->user_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date
        ]);

        $itemIds = $request->itemIds;
        foreach($itemIds as $itemId){
            $item = Item::findOrFail($itemId);
            $newRequest->items()->attach($item);
        }
        $items = $newRequest->items()->toArray();
        return response()->json($items, 201);
    }

    public function acceptRequest(RouteRequest $req, Request $request)
    {
        $request->accepted = $req->accepted;
        $request->save();
        return response()->json($request, 200);
    }

    public function index()
    {
        # code...
    }
}
