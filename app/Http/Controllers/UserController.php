<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
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
        'name' => 'required|max:256',
        'email' => 'required|email',
        'password' => ['required','string','confirmed'],//,Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        'password_confirmation' => 'required',
        'group_number' => 'required|integer|between:1,4000',
        'district' => 'required|integer|between:1,10',
        'phone' => 'nullable|integer',
        'is_group' => 'required|boolean',
        'is_storekeeper' => 'required|boolean',
        'is_admin' => 'required|boolean',
        ]);

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
        'name' => 'sometimes|max:256',
        'email' => 'sometimes|email',
        'password' => ['sometimes','string'],//,'confirmed',Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        'password_confirmation' => 'sometimes',
        'group_number' => 'sometimes|integer|between:1,4000',
        'district' => 'sometimes|integer|between:1,10',
        'phone' => 'sometimes|nullable|integer',
        'is_group' => 'prohibited',
        'is_storekeeper' => 'prohibited',
        'is_admin' => 'prohibited',
        ]);

        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
