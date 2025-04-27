<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function create()
    {
        return inertia('Account/Register');
    }

    public function store(Request $request)
    {
        $user = User::make(
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed'
            ])
        );

        $user->save();
        Auth::login($user);

        return redirect()->route('items.index')->with('success', 'Account Created');
    }
}
