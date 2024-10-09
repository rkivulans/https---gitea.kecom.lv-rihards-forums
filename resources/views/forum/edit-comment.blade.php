<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-gray-800 via-gray-700 to-gray-600 rounded-lg p-4 shadow-md">
            <a href="{{ route("forum.index") }}" class="text-white-600">
                    {{ __('Forum') }}
            </a>
            <span class="text-white-600">/</span>
            <a href="{{ route("forum.show", $comment->forum_post_id) }}" class="text-white-600">
                {{ $comment->post->title }}
            </a>
            <span class="text-white-600">/</span>
            {{ __('Edit Comment') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-900 shadow-lg sm:rounded-lg border border-gray-700 dark:border-gray-600 p-6">
                <form action="{{ route('forum.comment.update', [$comment->post, $comment]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="content" class="block text-gray-300">{{ __('Comment Content') }}</label>
                        <textarea id="content" name="content" rows="5" class="w-full px-4 py-2 border rounded-lg bg-gray-700 text-gray-300 border-gray-600">{{ old('content', $comment->content) }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-150 ease-in-out">
                            {{ __('Update Comment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
