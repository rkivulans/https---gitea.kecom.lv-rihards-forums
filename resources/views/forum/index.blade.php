<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-gray-800 via-gray-700 to-gray-600 rounded-lg p-4 shadow-md flex justify-between">
            {{ __('Forum Posts') }}
            <!-- Add Post Button -->
            <a href="{{ route('forum.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-150 ease-in-out">
                {{ __('Add Post') }}
            </a>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-900 shadow-lg sm:rounded-lg border border-gray-700 dark:border-gray-600 p-6">
                @foreach($posts as $post)
                    <div class="p-4 mb-4 bg-gray-700 rounded-lg border border-gray-600">
                        <!-- Post Title as a Link -->
                        <a href="{{ route('forum.show', $post->id) }}" class="text-xl font-semibold text-red-500 hover:underline">
                            {{ $post->title }} ({{ $post->comments_count }})
                        </a>
                        <p class="text-sm text-gray-300 mt-1">
                            {{ $post->created_at->format('Y. \g\a\d\a j. F') }} - {{ $post->user->name }}
                        </p>
                    </div>
                @endforeach

                @if($posts->isEmpty())
                    <p class="text-gray-400">{{ __('No forum posts available.') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
