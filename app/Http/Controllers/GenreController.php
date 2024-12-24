<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 3);
        $genres = Genre::paginate($perPage);
    
        return response()->json($genres);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:genres,name']);
        $genre = Genre::create($request->all());

        return response()->json($genre, 201);
    }

    public function show(Genre $genre, Request $request)
    {
        $perPage = $request->input('per_page', 3);
        
        $movies = $genre->movies()->paginate($perPage);
    
        return response()->json($movies);
    }
    

    public function update(Request $request, Genre $genre)
    {
        $request->validate(['name' => 'required|string|unique:genres,name']);
        $genre->update($request->all());
        
        return response()->json($genre);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json(['message' => 'Genre deleted']);
    }
}
