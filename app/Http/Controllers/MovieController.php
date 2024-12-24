<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 3);
        $movies = Movie::with('genres')->paginate($perPage);
        
        return response()->json($movies);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id'
        ]);

        if (Movie::where('title', $request->title)->exists()) {
            return response()->json(['message' => 'Movie with this title already exists'], 409); // 409 Conflict
        }

        $posterPath = 'posters/default.jpg';
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        } elseif ($request->filled('poster_url')) {
            // Загрузка изображения по URL
            $posterUrl = $request->poster_url;
            $posterContents = Http::get($posterUrl)->body(); // Скачивание файла
            $posterExtension = pathinfo(parse_url($posterUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
            $posterFilename = 'posters/' . uniqid() . '.' . $posterExtension;
    
            Storage::disk('public')->put($posterFilename, $posterContents);
            $posterPath = $posterFilename;
        }

        $movie = Movie::create([
            'title' => $request->title,
            'is_published' => false, // Создаётся как неопубликованное
            'poster_url' => $posterPath,
        ]);

        $movie->genres()->sync($request->get('genres', []));
        return response()->json($movie->load('genres'), 201);
    }

    public function show(Movie $movie)
    {
        return response()->json($movie->load('genres'));
    }

    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title' => 'required|string',
            'is_published' => 'boolean',
            'poster_url' => 'nullable|string',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id'
        ]);

        $movie->update($request->only(['title', 'is_published', 'poster_url']));
        $movie->genres()->sync($request->get('genres', []));
        return response()->json($movie->load('genres'));
    }

    public function destroy(Movie $movie)
    {
        
        $attributes = $movie->getAttributes();
        $posterPath = $attributes['poster_url'];

        if ($posterPath && Storage::exists('public/' . $posterPath)) {
            Storage::delete('public/' . $posterPath);
        }

        $movie->delete();
        return response()->json(['message' => 'Movie and associated poster deleted']);
    }

    public function publish(Movie $movie)
    {
        if ($movie->is_published) {
            return response()->json(['message' => 'Movie is already published'], 400);
        }

        $movie->update(['is_published' => true]);
        return response()->json(['message' => 'Movie published successfully', 'movie' => $movie]);
    }

}
