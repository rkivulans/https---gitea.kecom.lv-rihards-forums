<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPost;
use App\Models\User;

class AdminForumController extends Controller
{
    public function index()
    {
        $posts = ForumPost::all();
        $users = User::where('id', '!=', auth()->id())
            ->where('admin')
            ->get();
        return view('adminforum.index', compact('posts', 'users'));
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

        return redirect()->route('adminforum.index')->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = ForumPost::findOrFail($id);
        $post->delete();

        return redirect()->route('adminforum.index')->with('success', 'Post deleted successfully!');
    }

    // Funkcija, lai dzēstu lietotāju
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('adminforum.index')->with('success', 'User deleted successfully!');
    }

    // Funkcija, lai bloķētu vai atbloķētu lietotāju
    public function blockUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->blocked_users === 'block') {
            $user->blocked_users = null; // Atbloķēt lietotāju, izdzēšot 'block' vērtību
        } else {
            $user->blocked_users = 'block'; // Bloķēt lietotāju, pievienojot 'block' vērtību
        }
    
        $user->save(); // Saglabāt izmaiņas datubāzē

        return redirect()->route('adminforum.index')->with('success', 'User block status updated!');
    }
}
