<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use Illuminate\Support\Facades\Log; // Importē Log

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
       // seit man japarbauda vai ielogojies UN vai admins
       if (! auth()->id() ) {
        return redirect('login');
        }

        return view('music.create');
    }

    /**
     * Store a new music track in the database.
     */
    public function store(Request $request)
    {
        // seit man japarbauda vai ielogojies UN vai admins
        
        // Validate input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'album' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'cover_image' => 'nullable|image|max:10240', // Maksimālais attēla izmērs 10MB
            'file_path' => 'required|mimes:mp3,wav|max:20480', // Maksimālais mūzikas faila izmērs 20MB
        ]);

        // Check and save cover image if present
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('cover_images', 'public');
            $validated['cover_image'] = 'storage/' . $coverImagePath;
        }

        $filePath = $request->file('file_path')->store('music_files', 'public');
        $validated['file_path'] = 'storage/' . $filePath;

        // Create a new record in the database
        $music = Music::create($validated);

        // Redirect back to the index view with a success message
        return redirect()->route('music.index')->with('success', 'Music added successfully!');
    }
}
