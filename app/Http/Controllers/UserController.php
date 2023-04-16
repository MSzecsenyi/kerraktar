<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\StoreResource;
use App\Models\Category;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->withCount(['takeOuts as has_requests' => function ($query) {
                $query->whereNull('end_date');
            }])
            ->orderBy('district')
            ->orderBy('name')
            ->paginate(30);

        return view('users', compact('users'));
    }

    public function create()
    {
        return view('user_create');
    }

    public function show(User $user)
    {
        if (!auth()->user()->is_admin && !auth()->user()->id == $user->id) {
            return response()->json("Unauthorized request", 401);
        }

        return $user;
    }

    public function store(StoreUserRequest $request)
    {
        error_log("kaki");
        if (!auth()->user()->is_admin) {
            return response()->json("Unauthorized request", 401);
        }
        $user = User::create($request->validated());

        return redirect()->route('users');
    }

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
