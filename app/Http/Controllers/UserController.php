<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResource;
use App\Models\Category;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->is_admin) {
            return response()->json("Unauthorized request", 401);
        }

        $users = User::all();

        if ($request->has('district')) {
            $users = $users->filter(function ($user) use ($request) {
                return $user->district == $request->district;
            });
        }

        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (!auth()->user()->is_admin && !auth()->user()->id == $user->id) {
            return response()->json("Unauthorized request", 401);
        }

        return $user;
    }

    public function check(Request $request)
    {
        $user = auth()->user();

        $stores = [];
        if ($user->is_storekeeper) {
            $stores = $user->stores()->get();
        } else {
            $stores = Store::where('district', $user->district)->get();
        }

        $response = [
            'user' => auth()->user(),
            'token' => $request->bearerToken(),
            'stores' => StoreResource::collection($stores)
        ];

        return response()->json($response, 200);

        return auth()->user();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->is_admin) {
            return response()->json("Unauthorized request", 401);
        }

        $fields = $request->validate([
            'name' => 'required|max:256|string',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'confirmed'], //,Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'password_confirmation' => 'required',
            'group_number' => 'required|integer|between:1,4000',
            'district' => 'required|integer|between:1,10',
            'phone' => 'nullable|integer',
            'is_group' => 'required|boolean',
            'is_storekeeper' => 'required|boolean',
            'is_admin' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'group_number' => $fields['group_number'],
            'district' => $fields['district'],
            'phone' => $fields['phone'],
            'is_group' => $fields['is_group'],
            'is_storekeeper' => $fields['is_storekeeper'],
            'is_admin' => $fields['is_admin'],
        ]);

        $token = $user->createToken('kerraktarToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
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
        if (!auth()->user()->is_admin && !auth()->user()->id == $user->id) {
            return response()->json("Unauthorized request", 401);
        }

        $request->validate([
            'name' => 'sometimes|max:256',
            'email' => 'sometimes|email',
            'password' => ['sometimes', 'string'], //,'confirmed',Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
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
        if (!auth()->user()->is_admin) {
            return response()->json("Unauthorized request", 401);
        }

        $user->delete();

        return response()->json(null, 204);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return [
            'message' => 'logged out'
        ];
    }

    public function logoutAll()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'string'], //,Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();
        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json("Incorrect credentials", 401);
        }

        $token = $user->createToken('kerraktarToken')->plainTextToken;


        $stores = [];
        if ($user->is_storekeeper) {
            $stores = $user->stores()->get();
        } else {
            $stores = Store::where('district', $user->district)->get();
        }

        $response = [
            'user' => $user,
            'token' => $token,
            'stores' => StoreResource::collection($stores)
        ];

        return response()->json($response, 200);
    }
}
