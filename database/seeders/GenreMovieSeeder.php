<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreMovieSeeder extends Seeder
{
    public function run()
    {
        $genreMovieRelations = [
            ['genre_id' => 1, 'movie_id' => 1], // Action - Inception
            ['genre_id' => 2, 'movie_id' => 2], // Comedy - The Matrix
            ['genre_id' => 3, 'movie_id' => 3], // Drama - Joker
            ['genre_id' => 4, 'movie_id' => 4], // Horror - The Conjuring
            ['genre_id' => 5, 'movie_id' => 5], // Thriller - The Dark Knight
            ['genre_id' => 6, 'movie_id' => 6], // Romance - The Notebook
            ['genre_id' => 7, 'movie_id' => 7], // Sci-Fi - Interstellar
            ['genre_id' => 8, 'movie_id' => 8], // Fantasy - Harry Potter
            ['genre_id' => 9, 'movie_id' => 9], // Mystery - Shutter Island
        ];

        foreach ($genreMovieRelations as $relation) {
            DB::table('genre_movie')->insert([
                'genre_id' => $relation['genre_id'],
                'movie_id' => $relation['movie_id'],
            ]);
        }
    }
}
