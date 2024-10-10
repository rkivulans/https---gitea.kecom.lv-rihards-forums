<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-gray-800 via-gray-700 to-gray-600 rounded-lg p-4 shadow-md">
            {{ __('Add New Music') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 p-6 rounded-lg mt-8 w-full">
                <!-- Mūzikas pievienošanas forma -->
                <form action="{{ route('music.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-white">Title</label>
                        <input type="text" id="title" name="title" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('title') }}">
                        @error('title')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="artist" class="block text-white">Artist</label>
                        <input type="text" id="artist" name="artist" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('artist') }}">
                        @error('artist')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="genre" class="block text-white">Genre</label>
                        <input type="text" id="genre" name="genre" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('genre') }}">
                        @error('genre')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="album" class="block text-white">Album</label>
                        <input type="text" id="album" name="album" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('album') }}">
                        @error('album')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="year" class="block text-white">Year</label>
                        <input type="number" id="year" name="year" class="w-full p-2 rounded bg-gray-800 text-white" value="{{ old('year') }}">
                        @error('year')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cover_image" class="block text-white">Cover Image</label>
                        <input type="file" id="cover_image" name="cover_image" class="w-full p-2 rounded bg-gray-800 text-white">
                        @error('cover_image')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="file_path" class="block text-white">Music File</label>
                        <input type="file" id="file_path" accept="audio/mp3,audio/wav" name="file_path" class="w-full p-2 rounded bg-gray-800 text-white">
                        @error('file_path')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Music</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
