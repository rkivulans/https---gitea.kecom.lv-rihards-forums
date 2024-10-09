<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\ForumPost;

class CommentController extends Controller
{
    public function store(Request $request, ForumPost $forum)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'forum_post_id' => $forum->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('forum.show', $forum)->with('success', 'Comment added successfully!');
    }

    public function destroy(ForumPost $forum, Comment $comment)
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403);  // Forbidden
        }

        $comment->delete();

        // Atgriežas uz postu, kurā bija dzēstais komentārs
        return redirect()->route('forum.show', $comment->forum_post_id)->with('success', 'Comment deleted successfully!');
    }

    public function edit(ForumPost $forum, Comment $comment)
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403);  // Forbidden
        }

        return view('forum.edit-comment', compact('comment'));
    }

    public function update(Request $request, ForumPost $forum, Comment $comment)
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403);  // Forbidden
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        // Atgriežas uz postu, kurā bija rediģētais komentārs
        return redirect()->route('forum.show', $comment->forum_post_id)->with('success', 'Comment updated successfully!');
    }
}
