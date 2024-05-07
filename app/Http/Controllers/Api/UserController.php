<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:24|min:3',
            'email' => 'required|email|max:144',
            'password' => 'required|min:8',
            'date_of_birth' => 'required|date|before:yesterday',
            'is_admin' => 'boolean',
        ]);
        return response()->json(User::create($validated));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $results = User::find($id);

        if(!$results) {
            return response()->json("User not found :|");
        }
        $filteredResults = $results->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'exp' => $user->exp,
                'coins' => $user->coins,
                'is_admin' =>$user->is_admin,
                'online_status'=>$user->online_status,
                'created_at' => $user->created_at,
            ];
        });
        return response()->json($filteredResults);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'string|max:24|min:3',
            'email' => 'email|max:144',
            'password' => 'min:8|confirmed',
            'date_of_birth' => 'date|before:yesterday',
        ]);
        $user->update($validated);
        return new $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json();
    }

    public function search(Request $request) {
        $term = $request->input('term');
        $results = User::where('username', 'LIKE', "%$term%")->get();
        $filteredResults = $results->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'exp' => $user->exp,
                'created_at' => $user->created_at,
            ];
        });
    
        return response()->json($filteredResults);
    }
}
