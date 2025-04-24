<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'david@example.com'],
            [
                'name' => 'Dav Ignatius',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            CategorySeeder::class,
            PodcastSeeder::class,
            EpisodeSeeder::class,
        ]);
    }
}
