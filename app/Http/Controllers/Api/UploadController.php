<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:48', 'min:1'],
            'description' => ['nullable', 'string', 'max:256'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'upload' => ['required', 'mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv,webm,webp', 'max:100000'],
        ]);

        $media_path = $request->file('upload')->store('media', 'public');

        $user = User::find($request->user_id);

        $user->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'media' => $media_path,
        ]);
        return response()->json([200,'epic']);
    }

    public function showPosts(Request $request)
    {
        $userId = $request->id;

        $results = Post::where('user_id', $userId)
        ->join('users','posts.user_id','=','users.id')
        ->select('users.username', 'posts.*')
        ->withCount(['likes' => function ($query) {
            $query->where('active', true);
        }])
        ->get();

        if (!$results) {
            return response()->json("No posts");
        }

        return response()->json($results);

    }

    public function deletePost(Request $request)
    {
        $postId = $request->id;

        Post::find($postId)->delete();

        return response()->json("Post deleted");
    }

    public function likePost(Request $request)
    {
        $postId = $request->post_id;
        $userId = $request->user_id;

        $existingLike = Like::where('post_id', $postId)->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->active = $existingLike->active ? false : true;
            $existingLike->save();
            return response()->json($existingLike->active ? 'liked' : 'unliked');
        }

        // Create a new like if not already liked
        Like::create([
            'post_id' => $postId,
            'user_id' => $userId,
            
        ]);

        return response()->json("liked");
    }
    
    public function index() {
        return Post::all()->count();
    }

}
