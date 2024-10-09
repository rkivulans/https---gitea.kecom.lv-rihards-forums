<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-black via-gray-800 to-purple-900 rounded-lg p-4 shadow-md">
            {{ __('Edit Forum Post') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-gray-800 via-black to-purple-900 shadow-lg rounded-lg border border-gray-700 p-6">
                <form action="{{ route('adminforum.update', $post->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-white">Title</label>
                        <input type="text" name="title" value="{{ $post->title }}" class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 mt-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-white">Description</label>
                        <textarea name="description" rows="5" class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 mt-2">{{ $post->description }}</textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-purple-800 hover:bg-purple-900 text-white rounded-lg">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
