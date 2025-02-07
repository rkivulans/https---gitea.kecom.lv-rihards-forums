<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-gray-800 via-gray-700 to-gray-600 rounded-lg p-4 shadow-md">
            <a href="{{ route("forum.index") }}" class="text-white-600">
                {{ ("Forum") }}
            </a>
            <span class="text-white-600">/</span>
            {{ $forum->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-900 shadow-lg sm:rounded-lg border border-gray-700 dark:border-gray-600 p-6">

                <!-- Success Messages -->
                @if (session('added'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">{{ __("Confirmed!") }}</strong>
                        <span class="block sm:inline">{{ session('added') }}</span>
                    </div>
                @endif
                
                @if (session('updated'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">{{ __("Confirmed!") }}</strong>
                        <span class="block sm:inline">{{ session('updated') }}</span>
                    </div>
                @endif

                @if (session('deleted'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">{{ __("Confirmed!") }}</strong>
                        <span class="block sm:inline">{{ session('deleted') }}</span>
                    </div>
                @endif
                
                <!-- Display Post Content -->
                <p class="text-gray-300 mb-4">{{ $forum->description }}</p>

                @if($forum->image_path)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $forum->image_path) }}">
                            <img src="{{ asset('storage/' . $forum->image_path) }}" alt="Post Image" class="w-1/3 h-auto rounded-lg border-gray-600 border-2">
                        </a>
                    </div>
                @endif

                @if($forum->youtube_link)
                    <div class="mt-4">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $forum->youtube_link }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endif

                <!-- Display Comments -->
                <div class="mt-6">
                    <h5 class="text-lg font-semibold text-red-500">{{ __('Comments') }}</h5>
                    @if($forum->comments && $forum->comments->isNotEmpty())
                        @foreach($forum->comments as $comment)
                            <div class="bg-gray-800 p-3 rounded-lg mt-3">
                                <p class="text-sm text-gray-400">{{ $comment->user->name }}: {{ $comment->content }}</p>

                                <!-- Edit and Delete buttons -->
                                @if(auth()->id() === $comment->user_id)
                                    <div class="flex space-x-2 mt-2">
                                        <a href="{{ route('forum.comment.edit', [$forum, $comment]) }}" class="text-blue-500 hover:underline">{{ __('Edit') }}</a>
                                        
                                        <form action="{{ route('forum.comment.destroy', [$forum,$comment]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-400">{{ __('No comments yet.') }}</p>
                    @endif
                </div>

                <!-- Add Comment Form -->
                <form action="{{ route('forum.comment.store', $forum) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-2">
                        <textarea name="content" rows="2" class="w-full px-4 py-2 border rounded-lg bg-gray-700 text-gray-300 border-gray-600" placeholder="{{ __('Add a comment...') }}"></textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-md shadow-sm border border-black focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-red-900 transition duration-150 ease-in-out">
                        {{ __('Post Comment') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
