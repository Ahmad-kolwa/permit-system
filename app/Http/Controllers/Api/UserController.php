<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,officer,accountant',
    ]);

    ////////////////////////WE CAN CREATE LIKE ////////////////////////////////
      //  $validated['password'] = Hash::make($validated['password']);
       //$user = User::create($validated);
                       
       ////OR//////

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
    ]);

    return response()->json([
        'success' => true,
        'message' => 'User created successfully',
        'data' => $user
    ], 201);
}
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6',
    //         'role' => 'required|in:admin,officer,accountant',
    //     ]);
    //     //if there are foreign key it will be         'park_id' => 'required|exists:parks,id',

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role' => $request->role,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'User created successfully',
    //         'data' => $user,
    //     ], 201);
    // }
}