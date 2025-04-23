<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Episodes",
 *     description="Podcast episode management"
 * )
 */
class EpisodeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/episodes",
     *     tags={"Episodes"},
     *     summary="List episodes with filters and pagination",
     *     operationId="getEpisodes",
     *     @OA\Parameter(name="podcast_id", in="query", description="Filter by podcast ID", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="title", in="query", description="Filter by episode title", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="sort_by", in="query", description="Field to sort by", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="sort_order", in="query", description="Sort order (asc or desc)", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="per_page", in="query", description="Number of items per page", required=false, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="List of episodes"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/episodes",
     *     tags={"Episodes"},
     *     summary="Create a new episode",
     *     operationId="storeEpisode",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"podcast_id", "title", "duration", "release_date"},
     *                 @OA\Property(property="podcast_id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="audio_url", type="string", format="binary"),
     *                 @OA\Property(property="duration", type="number"),
     *                 @OA\Property(property="release_date", type="string", format="date")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Episode created successfully"
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'podcast_id' => 'required|exists:podcasts,id',
            'title' => 'required|string|max:255',
            'audio_url' => 'nullable|file|mimes:mp3,wav,ogg|max:10240', // max 10MB
            'duration' => 'required|numeric',
            'release_date' => 'required|date',
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
        ]);

        return response()->json([
            'message' => 'Episode created successfully',
            'episode' => $episode
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/episodes/{id}",
     *     tags={"Episodes"},
     *     summary="Get a single episode by ID",
     *     operationId="getEpisode",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Episode ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Episode retrieved successfully"
     *     ),
     *     @OA\Response(response=404, description="Episode not found")
     * )
     */
    public function show(string $id)
    {
        $episode = Episode::findOrFail($id);

        return response()->json([
            'episode' => $episode
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/episodes/{id}",
     *     tags={"Episodes"},
     *     summary="Update an existing episode",
     *     operationId="updateEpisode",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Episode ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="duration", type="number"),
     *                 @OA\Property(property="release_date", type="string", format="date"),
     *                 @OA\Property(property="audio_url", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Episode updated successfully"
     *     ),
     *     @OA\Response(response=404, description="Episode not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/episodes/{id}",
     *     tags={"Episodes"},
     *     summary="Delete an episode",
     *     operationId="deleteEpisode",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Episode ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Episode deleted successfully"
     *     ),
     *     @OA\Response(response=404, description="Episode not found")
     * )
     */
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
