<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class UploadController extends Controller
{
    public function upload(Request $request) {
        $request->validate([
            'title' => ['required', 'string', 'max:48', 'min:1'],
            'description' => ['nullable', 'string', 'max:256'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'upload' => ['required', 'mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv,webm', 'max:100000'],
        ]);
    
        $media_path = $request->file('upload')->store('media', 'public');
    
        $user = User::find($request->user_id);
        
        $user->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'media' => $media_path,
        ]);
        return response()->json();
    }
}
