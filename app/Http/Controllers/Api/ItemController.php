<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Resources\Item\ItemResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $query = Item::query();
            if (isset($filter['type']) && $filter['type'] != 'Type') {
                $query->where('type', $filter['type']);
            }
            if (isset($filter['color']) && $filter['color'] != 'Color') {
                $query->where('color', $filter['color']);
            }
            if (isset($filter['minPrice']) && is_numeric($filter['minPrice'])) {
                $query->where('price', '>=', $filter['minPrice']);
            }
            if (isset($filter['maxPrice']) && is_numeric($filter['maxPrice'])) {
                $query->where('price', '<=', $filter['maxPrice']);
            }
            if (isset($filter['order'])) {
                if ($filter['order'] == 'AZ') {
                    $query->orderBy('title', 'asc')
                        ->get();
                }
                if ($filter['order'] == 'ZA') {
                    $query->orderBy('title', 'desc')
                        ->get();
                }
                if ($filter['order'] == 'priceAsc') {
                    $query->orderBy('price', 'asc')
                        ->get();
                }
                if ($filter['order'] == 'priceDesc') {
                    $query->orderBy('price', 'desc')
                        ->get();
                }
            }

            $filtered = $query->get();

            // if (!$filtered) {
            //     return response()->json("No items found with such criteria");
            // }
            return $filtered;
        }

        return Item::all();
    }


    public function itemCount()
    {
        return Item::all()->count();

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'color' => 'required|string',
            'price' => 'required|integer',
            'type' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png|max:20000'
        ]);
        $imagePath = $validated['image']->store('items', 'public');
        Item::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'color' => $validated['color'],
            'price' => $validated['price'],
            'type' => $validated['type'],
            'image' => $imagePath,
        ]);
        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $results = Item::find($id);

        if (!$results) {
            return response()->json(404, "Item not found");
        }

        return new ItemResource($results);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'color' => 'required|string',
            'price' => 'required|integer',
            'type' => 'required|string',
            'image' => 'mimes:jpg,jpeg,png|max:20000'
        ]);
        $imagePath = $validated['image']->store('items', 'public');

        Item::find($id)->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'color' => $validated['color'],
            'price' => $validated['price'],
            'type' => $validated['type'],
            'image' => $imagePath,
        ]);
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json();
    }

    public function search(Request $request)
    {

        $term = $request->input('term');
        $results = Item::where('title', 'LIKE', "%$term%")->get();

        return response()->json($results);

    }
}
