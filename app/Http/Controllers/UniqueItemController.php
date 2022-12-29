<?php

namespace App\Http\Controllers;

use App\Models\UniqueItem;
use App\Http\Requests\StoreUniqueItemRequest;
use App\Http\Requests\UpdateUniqueItemRequest;

class UniqueItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UniqueItem  $UniqueItem
     * @return \Illuminate\Http\Response
     */
    public function show(UniqueItem $UniqueItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UniqueItem  $UniqueItem
     * @return \Illuminate\Http\Response
     */
    public function edit(UniqueItem $UniqueItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UniqueItem  $UniqueItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(UniqueItem $UniqueItem)
    {
        //
    }
}
