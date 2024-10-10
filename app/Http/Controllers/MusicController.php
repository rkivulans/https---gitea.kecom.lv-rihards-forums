<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;

class MusicController extends Controller
{
    /**
     * Display a listing of the music tracks.
     */
    public function index()
    {
        $music = Music::all();
        return view('music.index', compact('music'));
    }

    /**
     * Show the form for creating a new music track.
     */
    public function create()
    {
        // Pārbauda, vai lietotājs ir ielogojies un ir administrators
        if (!auth()->check() || !auth()->user()->admin) {
            return redirect('login')->with('error', 'You must be an administrator to add music.');
        }

        return view('music.create');
    }

    /**
     * Store a new music track in the database.
     */
    public function store(Request $request)
    {
        // Pārbauda, vai lietotājs ir ielogojies un ir administrators
        if (!auth()->check() || !auth()->user()->admin) {
            return redirect('login')->with('error', 'You must be an administrator to add music.');
        }

        // Validē ievades datus
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'album' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'cover_image' => 'nullable|image|max:10240', // Maksimālais attēla izmērs 10MB
            'file_path' => 'required|mimes:mp3,wav|max:20480', // Maksimālais mūzikas faila izmērs 20MB
        ]);

        // Saglabā albuma attēlu, ja tāds ir
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('cover_images', 'public');
            $validated['cover_image'] = 'storage/' . $coverImagePath;
        }

        // Saglabā mūzikas failu
        $filePath = $request->file('file_path')->store('music_files', 'public');
        $validated['file_path'] = 'storage/' . $filePath;

        // Izveido jaunu ierakstu datubāzē
        Music::create($validated);

        // Pārvirza atpakaļ uz mūzikas skatu ar veiksmīgu ziņojumu
        return redirect()->route('music.index')->with('success', 'Music added successfully!');
    }
}
