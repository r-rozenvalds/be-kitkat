<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Cat;
use App\Http\Resources\CatResource;
use App\Http\Requests\CatRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CatResource::collection(Cat::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CatRequest $request)
    {
        $validated = $request->validated();
        $validated["user_id"] = Auth::user()->id;
        $cat = Cat::create($validated);
        return new CatResource($cat);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cat $cat)
    {
        return new CatResource($cat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CatRequest $request, Cat $cat)
    {
        $validated = $request->validated();
        $cat->update($validated);
        return new CatResource($cat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cat $cat)
    {
        $cat->delete();
        return response()->json();
    }

    public function checkUser(Request $request) {
        $results = Cat::where('user_id', $request->id)->get();
        return response()->json([
            'exists' => !$results->isEmpty()
        ]);
        
    }
}
