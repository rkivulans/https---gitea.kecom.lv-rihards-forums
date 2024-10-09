<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-gray-800 via-gray-700 to-gray-600 rounded-lg p-4 shadow-md">
            {{ __('Add New Music') }}
        </h2>
    </x-slot>

    @if (session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @dump($errors)
    <div class="py-12 bg-gray-900">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 p-6 rounded-lg mt-8 w-full">
                <!-- Mūzikas pievienošanas forma -->
                <form action="{{ route('music.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-white">Title</label>
                        <input type="text" name="title" class="w-full p-2 rounded bg-gray-800 text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Artist</label>
                        <input type="text" name="artist" class="w-full p-2 rounded bg-gray-800 text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Genre</label>
                        <input type="text" name="genre" class="w-full p-2 rounded bg-gray-800 text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Album</label>
                        <input type="text" name="album" class="w-full p-2 rounded bg-gray-800 text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Year</label>
                        <input type="number" name="year" class="w-full p-2 rounded bg-gray-800 text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Cover Image</label>
                        <input type="file" name="cover_image" class="w-full p-2 rounded bg-gray-800 text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-white">Music File</label>
                        <input type="file" accept="audio/mp3,audio/wav" name="file_path" class="w-full p-2 rounded bg-gray-800 text-white">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Music</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
