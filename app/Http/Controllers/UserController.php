<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'driving_license' => 'required|unique:users',
        ]);
        User::create($request->all());


        return redirect()->route('login')
            ->with('success', 'Registration successful!');
    }
}
