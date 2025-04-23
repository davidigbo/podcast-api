<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpisodeController extends Controller
{
    // Fetch all episodes with optional filters
    public function index(Request $request)
    {
        $query = Episode::query();

        if ($request->has('podcast_id')) {
            $query->where('podcast_id', $request->podcast_id);
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
        $episodes = $query->paginate($perPage);

        return response()->json([
            'episodes' => $episodes
        ]);
    }

    // Store a new episode
    public function store(Request $request)
    {
        $validated = $request->validate([
            'podcast_id' => 'required|exists:podcasts,id',
            'title' => 'required|string|max:255',
            'audio_url' => 'nullable|file|mimes:mp3,wav,ogg|max:10240', // max 10MB
            'duration' => 'required|numeric',
            'release_date' => 'required|date',
            'podcast_id' => 'required|exists:podcasts,id',
            // 'user_id' => 'required|exists:users,id'
        ]);

        $audioPath = null;
        if ($request->hasFile('audio_url')) {
            $audioPath = $request->file('audio_url')->store('audios', 'public');
        }

        $episode = Episode::create([
            'podcast_id' => $validated['podcast_id'],
            'title' => $validated['title'],
            'audio_url' => $audioPath,
            'duration' => $validated['duration'],
            'release_date' => $validated['release_date'],
            'podcast_id' => $validated['podcast_id'],
            // 'user_id' => $validated['user_id'],
        ]);

        return response()->json([
            'message' => 'Episode created successfully',
            'episode' => $episode
        ], 201);
    }

    // Show a specific episode
    public function show(string $id)
    {
        $episode = Episode::findOrFail($id);

        return response()->json([
            'episode' => $episode
        ]);
    }

    // Update an episode
    public function update(Request $request, string $id)
    {
        $episode = Episode::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|numeric',
            'release_date' => 'sometimes|required|date',
            'audio_url' => 'sometimes|file|mimes:mp3,wav,ogg|max:10240',
        ]);

        if ($request->hasFile('audio_url')) {
            if ($episode->audio_url) {
                Storage::disk('public')->delete($episode->audio_url);
            }
            $audioPath = $request->file('audio_url')->store('audios', 'public');
        } else {
            $audioPath = $episode->audio_url;
        }

        $episode->update([
            'title' => $validated['title'] ?? $episode->title,
            'duration' => $validated['duration'] ?? $episode->duration,
            'release_date' => $validated['release_date'] ?? $episode->release_date,
            'audio_url' => $audioPath,
        ]);

        return response()->json([
            'message' => 'Episode updated successfully',
            'episode' => $episode
        ]);
    }

    // Delete an episode
    public function destroy(Request $request, string $id)
    {
        $episode = Episode::findOrFail($id);

        if ($episode->audio_url) {
            Storage::disk('public')->delete($episode->audio_url);
        }

        $episode->delete();

        return response()->json([
            'message' => 'Episode deleted successfully',
        ]);
    }
}
