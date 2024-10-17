<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-black via-gray-800 to-purple-900 rounded-lg p-4 shadow-md">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-gray-800 via-black to-purple-900 shadow-lg rounded-lg border border-gray-700 p-6">

                <!-- Forum Posts Table -->
                <div class="bg-gray-800 rounded-lg shadow-lg p-4">
                    <h3 class="text-white mb-4">Forum Posts</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full bg-transparent text-left">
                            <thead>
                                <tr class="bg-gray-800 text-white">
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Title</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Description</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr class="hover:bg-gray-700">
                                        <td class="py-2 px-4 border-b border-gray-600 text-white">{{ $post->title }}</td>
                                        <td class="py-2 px-4 border-b border-gray-600 text-gray-300">{{ Str::limit($post->description, 50) }}</td>
                                        <td class="py-2 px-4 border-b border-gray-600">
                                            <a href="{{ route('adminforum.edit', $post->id) }}" class="text-blue-400 hover:text-blue-600">Edit</a>
                                            <form action="{{ route('adminforum.destroy', $post->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 ml-4">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- User Comments Table -->
                <div class="bg-gray-800 rounded-lg shadow-lg p-4 mt-8">
                    <h3 class="text-white mb-4">User Comments</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full bg-transparent text-left">
                            <thead>
                                <tr class="bg-gray-800 text-white">
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Comment</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">User</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Post</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                    <tr class="hover:bg-gray-700">
                                        <td class="py-2 px-4 border-b border-gray-600 text-white">{{ $comment->content }}</td>
                                        <td class="py-2 px-4 border-b border-gray-600 text-gray-300">{{ $comment->user->name }}</td>
                                        <td class="py-2 px-4 border-b border-gray-600 text-gray-300">{{ $comment->post->title }}</td>
                                        <td class="py-2 px-4 border-b border-gray-600">
                                            <form action="{{ route('adminforum.deleteComment', $comment->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 ml-4">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- User Management Table -->
                <div class="bg-gray-800 rounded-lg shadow-lg p-4 mt-8">
                    <h3 class="text-white mb-4">Registered Users</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full bg-transparent text-left">
                            <thead>
                                <tr class="bg-gray-800 text-white">
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Name</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Email</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    @if(!$user->admin)
                                        <tr class="hover:bg-gray-700">
                                            <td class="py-2 px-4 border-b border-gray-600 text-white">{{ $user->name }}</td>
                                            <td class="py-2 px-4 border-b border-gray-600 text-gray-300">{{ $user->email }}</td>
                                            <td class="py-2 px-4 border-b border-gray-600">
                                                <form action="{{ route('adminforum.deleteUser', $user->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-600 ml-4">Delete</button>
                                                </form>
                                                <form action="{{ route('adminforum.blockUser', $user->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-yellow-400 hover:text-yellow-600 ml-4">
                                                        {{ $user->blocked_users == 'block' ? 'Unblock' : 'Block' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Music Management Table -->
                <div class="bg-gray-800 rounded-lg shadow-lg p-4 mt-8">
                    <h3 class="text-white mb-4">Available Music Tracks</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full bg-transparent text-left">
                            <thead>
                                <tr class="bg-gray-800 text-white">
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Title</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Artist</th>
                                    <th class="py-2 px-4 border-b-2 border-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($music as $track)
                                    <tr class="hover:bg-gray-700">
                                        <td class="py-2 px-4 border-b border-gray-600 text-white">{{ $track->title }}</td>
                                        <td class="py-2 px-4 border-b border-gray-600 text-gray-300">{{ $track->artist }}</td>
                                        <td class="py-2 px-4 border-b border-gray-600">
                                            <form action="{{ route('adminforum.deleteMusic', $track->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 ml-4">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
