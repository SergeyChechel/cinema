<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesSeeder extends Seeder
{
    public function run()
    {
        $movies = [
            ['title' => 'Inception', 'is_published' => true, 'poster_url' => 'https://ru-images-s.kinorium.com/movie/300/472809.jpg?1678572129'],
            ['title' => 'The Matrix', 'is_published' => true, 'poster_url' => 'https://ru-images.kinorium.com/movie/1080/116780.jpg?1678571724'],
            ['title' => 'Joker', 'is_published' => false, 'poster_url' => null],
            ['title' => 'The Conjuring', 'is_published' => false, 'poster_url' => null],
            ['title' => 'The Dark Knight', 'is_published' => false, 'poster_url' => null],
            ['title' => 'The Notebook', 'is_published' => false, 'poster_url' => null],
            ['title' => 'Interstellar', 'is_published' => false, 'poster_url' => null],
            ['title' => 'Harry Potter', 'is_published' => false, 'poster_url' => null],
            ['title' => 'Shutter Island', 'is_published' => false, 'poster_url' => null],
        ];
        

        foreach ($movies as $movie) {
            DB::table('movies')->insert([
                'title' => $movie['title'],
                'is_published' => $movie['is_published'],
                'poster_url' => $movie['poster_url'],
            ]);
        }
    }
}
