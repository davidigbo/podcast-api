<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Episode;
use App\Models\Podcast;

class EpisodeSeeder extends Seeder
{
    public function run(): void
    {
        $podcasts = Podcast::all();

        foreach ($podcasts as $podcast) {
            Episode::factory()->count(3)->create([
                'podcast_id' => $podcast->id,
                'title' => 'Episode 1',
                'audio_url' => 'https://example.com/audio.mp3',
                'duration' => 3600, // Duration in seconds
                'release_date' => now(),
            ]);
        }
    }
}
