<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPost;
use App\Models\User;
use App\Models\Music;
use App\Models\Comment;

class AdminForumController extends Controller
{
    public function index()
    {
        $posts = ForumPost::all();
        $users = User::where('id', '!=', auth()->id())->where('admin')->get();
        $music = Music::all();
        $comments = Comment::with('user', 'post')->get();
        return view('adminforum.index', compact('posts', 'users', 'music', 'comments'));
    }

    public function edit($id)
    {
        $post = ForumPost::findOrFail($id);
        return view('adminforum.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post = ForumPost::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('adminforum.index')->with('updated', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = ForumPost::findOrFail($id);
        $post->delete();

        return redirect()->route('adminforum.index')->with('deleted', 'Post deleted successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('adminforum.index')->with('deleted', 'User deleted successfully!');
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->blocked_users === 'block') {
            $user->blocked_users = null;
            $status = 'User unblocked successfully!';
        } else {
            $user->blocked_users = 'block';
            $status = 'User blocked successfully!';
        }

        $user->save();

        return redirect()->route('adminforum.index')->with('status', $status);
    }

    public function deleteMusic($id)
    {
        $track = Music::findOrFail($id);
        $track->delete();

        return redirect()->route('adminforum.index')->with('deleted', 'Music track deleted successfully!');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('adminforum.index')->with('deleted', 'Comment deleted successfully!');
    }
}
