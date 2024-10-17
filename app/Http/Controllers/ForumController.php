<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPost;

class ForumController extends Controller
{
    public function index()
    {
        // Retrieve all forum posts and display them in the forum.index view
        $posts = ForumPost::with(['user'])->withCount('comments')->get();
        return view('forum.index', compact('posts'));
    }

    public function show(ForumPost $forum)
    {
        $forum = $forum->load('comments.user');
        return view('forum.show', compact('forum'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        if (! auth()->id() ) {
            return redirect('login');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|max:9000',  // Validate image
            'youtube_link' => 'nullable|url',  // Validate YouTube link
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('forum_images', 'public');  // Store image in public folder
        }

        // Create a new forum post
        ForumPost::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'image_path' => $imagePath,
            'youtube_link' => $this->extractYoutubeId($request->youtube_link),
        ]);

        return redirect()->route('forum.index')->with('success', 'Post created successfully!');
    }

    // Helper function to extract YouTube video ID
    private function extractYoutubeId($url)
    {
        if (preg_match('/(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        } elseif (preg_match('/(?:https?:\/\/)?(?:www\.)?youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
