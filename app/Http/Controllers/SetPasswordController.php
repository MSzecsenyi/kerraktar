<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use Carbon\Carbon;

class SetPasswordController extends Controller
{
    public function create()
    {
        return view('setpassword');
    }

    public function store(StorePasswordRequest $request)
    {
        error_log(Carbon::Now());
        auth()->user()->update([
            'password' => bcrypt($request->password),
            'email_verified_at' => Carbon::now(),
        ]);

        return redirect()->route('users')->with('status', 'Jelszó sikeresen beállítva');
    }
}
