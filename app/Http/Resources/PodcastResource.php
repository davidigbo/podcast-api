<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PodcastResource extends JsonResource
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
            'category_id'   => $this->category_id,
            'user_id'      => $this->user_id,
            'description'   => $this->description,
            'image'         => $this->image, 
            'author'        => $this->author,
            'category'      => new CategoryResource($this->whenLoaded('category')), 
            'episodes'      => EpisodeResource::collection($this->whenLoaded('episodes')), 
            'created_at'    => $this->created_at?->toDateTimeString(),
            'updated_at'    => $this->updated_at?->toDateTimeString(),
        ];
    }
}
