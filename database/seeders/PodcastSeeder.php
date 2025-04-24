<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Podcast;
use App\Models\User;

class PodcastSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // Assumes at least one user exists
        $categories = Category::pluck('id');

        Podcast::factory()->create([
            'title' => 'Laravel for Beginners',
            'image' => 'https://example.com/image.jpg',
            'author' => 'John Doe',
            'description' => 'A podcast about learning Laravel.',
            'category_id' => 1,
        ]);
            
    }
}