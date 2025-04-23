<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function index(Request $request)
    {
        $query = Podcast::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('sort_by')) {
            $sortField = $request->get('sort_by');
            $sortOrder = $request->get('sort_order', 'asc');
            $query->orderBy($sortField, $sortOrder);
        }

        $perPage = $request->get('per_page', 10);
        $podcasts = $query->paginate($perPage);

        return response()->json([
            'podcasts' => $podcasts
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
    
        $podcast = Podcast::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'author' => $validated['author'],
            'is_featured' => $validated['is_featured'] ?? false,
            'image' => $imagePath,
        ]);
    
        return response()->json([
            'message' => 'Podcast created successfully',
            'podcast' => $podcast,
        ], 201);
    }    

    public function show(string $id)
    {
        $podcast = Podcast::findOrFail($id);

        return response()->json([
            'podcast' => $podcast
        ]);
    }

    public function update(Request $request, string $id)
    {
        $podcast = Podcast::findOrFail($id);

        \Log::info('Request Data:', $request->all());

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'author' => 'sometimes|required|string|max:255',
            'is_featured' => 'sometimes|boolean',
            'image' => 'sometimes|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($podcast->image) {
                Storage::disk('public')->delete($podcast->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $podcast->image;
        }

        $podcast->update([
            'title' => $validated['title'] ?? $podcast->title,
            'description' => $validated['description'] ?? $podcast->description,
            'category_id' => $validated['category_id'] ?? $podcast->category_id,
            'author' => $validated['author'] ?? $podcast->author,
            'is_featured' => $validated['is_featured'] ?? $podcast->is_featured,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Podcast updated successfully',
            'podcast' => $podcast,
        ], 200);
    }

    public function destroy(Request $request, string $id)
    {
        $podcast = Podcast::findOrFail($id);

        if ($podcast->image) {
            Storage::disk('public')->delete($podcast->image);
        }

        $podcast->delete();

        return response()->json([
            'message' => 'Podcast deleted successfully',
        ], 200);
    }
}
