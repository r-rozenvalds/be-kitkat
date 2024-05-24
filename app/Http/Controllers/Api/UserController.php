<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User\UserInfo;


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

        if (!$results) {
            return response()->json("User not found :|");
        }

        return new UserInfo($results);
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

    public function search(Request $request)
    {
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

    public function friend(Request $request)
    {
        $userId = $request->input('user_id_1');
        $friendId = $request->input('user_id_2');
        $status = $request->input('status', 'pending');

        $user = User::find($userId);

        $user->friends()->attach($friendId, ['status' => $status]);

        return response()->json($friendId);
    }

    public function showFriends(Request $request)
    {
        $userId = $request->id;

        $friendsAsUser1 = \DB::table('users')
            ->join('friendships', 'users.id', '=', 'friendships.user_id_2')
            ->where('friendships.user_id_1', '=', $userId)
            ->where('status', '=', 'accepted')
            ->select('users.id','username', 'exp', 'friendships.updated_at')
            ->get();

        $friendsAsUser2 = \DB::table('users')
            ->join('friendships', 'users.id', '=', 'friendships.user_id_1')
            ->where('friendships.user_id_2', '=', $userId)
            ->where('status', '=', 'accepted')
            ->select('users.id','username', 'exp', 'friendships.updated_at')
            ->get();

        $results = $friendsAsUser1->merge($friendsAsUser2);

        return response()->json($results);
    }

    public function showPendingFriends(Request $request) {
        $userId = $request->id;

        $pendingFriends = \DB::table('users')
            ->join('friendships', 'users.id', '=', 'friendships.user_id_2')
            ->where('friendships.user_id_1', '=', $userId)
            ->where('status', '=', 'pending')
            ->select('users.id','username', 'exp', 'friendships.updated_at', 'status')
            ->get();
        
        return response()->json($pendingFriends);
    }

    public function showIncomingFriends(Request $request) {
        $userId = $request->id;

        $incomingFriends = \DB::table('users')
            ->join('friendships', 'users.id', '=', 'friendships.user_id_1')
            ->where('friendships.user_id_2', '=', $userId)
            ->where('status', '=', 'pending')
            ->select('users.id','username', 'exp', 'friendships.updated_at', 'friendships.id AS friendshipId')
            ->get();


        return response()->json($incomingFriends);
    }

    public function acceptFriend(Request $request) {
        $friendshipId = $request->id;
        

        \DB::table('friendships')->where('id', $friendshipId)->update(['status' => 'accepted']);

        return response()->json(['message' => 'friendship accepted!']);
    }

    public function declineFriend(Request $request){
        $friendshipId = $request->id;
        

        \DB::table('friendships')->where('id', $friendshipId)->delete();

        return response()->json(['message' => 'friendship declined!']);
    }
    }
