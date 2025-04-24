<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'podcast_id'   => $this->podcast_id, 
            'audio_url'     => $this->audio_url, 
            'duration'      => $this->duration, 
            'release_date'  => $this->release_date?->toDateString(), 
            'podcast'       => new PodcastResource($this->whenLoaded('podcast')),
            'created_at'    => $this->created_at?->toDateTimeString(), 
            'updated_at'    => $this->updated_at?->toDateTimeString(), 
        ];
    }
}
