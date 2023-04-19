<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;

class SetPasswordController extends Controller
{
    public function create()
    {
        return view('setpassword');
    }

    public function store(StorePasswordRequest $request)
    {
        auth()->user->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('users')->with('status', 'Jelszó sikeresen beállítva');
    }
}
