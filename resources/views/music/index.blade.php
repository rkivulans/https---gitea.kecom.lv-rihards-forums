<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-gray-800 via-gray-700 to-gray-600 rounded-lg p-4 shadow-md">
            {{ __('Music Library') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Poga pievienot mūziku (redzama tikai adminiem) -->
            @if(auth()->user() && auth()->user()->admin)
                <a href="{{ route('music.create') }}" class="bg-blue-500 text-white p-2 rounded mb-4">Add New Music</a>
            @endif

            <div class="bg-gray-800 shadow-lg sm:rounded-lg border border-gray-700 p-6 flex flex-col sm:flex-row">
                <!-- Track List -->
                <div class="flex-1 mr-6">
                    <h3 class="text-xl font-bold text-white mb-4">Track List</h3>
                    <ul class="space-y-2">
                        @forelse($music as $index => $track)
                            <li class="text-white hover:text-teal-400 cursor-pointer transition" onclick="playTrack({{ $index }})">
                                {{ sprintf('%02d', $index + 1) }}. {{ $track->title }} - {{ $track->artist }}
                            </li>
                        @empty
                            <li class="text-gray-400">{{ __('No music tracks available.') }}</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Music Player -->
                <div class="flex-1 bg-gray-900 p-6 rounded-lg flex flex-col items-center">
                    <img id="albumCover" src="" alt="Album Cover" class="w-48 h-48 rounded-lg mb-4 hidden">
                    <p id="trackTitle" class="text-white text-lg font-bold mb-2 hidden"></p>
                    <p id="trackArtist" class="text-gray-400 text-sm mb-4 hidden"></p>
                    
                    <audio id="audioPlayer" controls class="hidden">
                        <source id="audioSource" src="" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>

                    <div class="flex items-center space-x-4 mb-4">
                        <!-- Player Controls -->
                        <button onclick="prevTrack()" class="bg-gray-700 text-white p-3 rounded-full hover:bg-gray-600 transition">
                            ⏮️
                        </button>
                        <button onclick="togglePlayPause()" class="bg-gray-700 text-white p-3 rounded-full hover:bg-gray-600 transition" id="playPauseBtn">
                            ▶️
                        </button>
                        <button onclick="nextTrack()" class="bg-gray-700 text-white p-3 rounded-full hover:bg-gray-600 transition">
                            ⏭️
                        </button>
                    </div>

                    <!-- Time Seek Bar -->
                    <div class="flex items-center space-x-2 w-full mb-4">
                        <input type="range" id="seekBar" class="w-full bg-gray-700 appearance-none h-1 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500" value="0" onchange="seekTrack()" style="accent-color: red;">
                    </div>

                    <!-- Volume Control with Speaker Icon -->
                    <div class="flex items-center space-x-2 w-full">
                        <input type="range" id="volumeBar" class="w-full bg-gray-700 appearance-none h-1 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500" value="100" max="100" onchange="changeVolume()" style="accent-color: red;">
                        <i class="fas fa-volume-up text-gray-400 hover:text-white cursor-pointer"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Music Player -->
    <script>
        const tracks = @json($music);  // Laravel blade directive to pass PHP variable to JavaScript
        const audioPlayer = document.getElementById('audioPlayer');
        const audioSource = document.getElementById('audioSource');
        const trackTitle = document.getElementById('trackTitle');
        const trackArtist = document.getElementById('trackArtist');
        const albumCover = document.getElementById('albumCover');
        const seekBar = document.getElementById('seekBar');
        const volumeBar = document.getElementById('volumeBar');
        const playPauseBtn = document.getElementById('playPauseBtn');

        let currentTrackIndex = 0;

        function loadTrack(index) {
            const track = tracks[index];
            audioSource.src = "{{ asset('') }}" + track.file_path;
            audioPlayer.load();
            
            trackTitle.textContent = track.title;
            trackArtist.textContent = track.artist;
            albumCover.src = track.cover_image ? "{{ asset('') }}" + track.cover_image : '';
            
            trackTitle.classList.remove('hidden');
            trackArtist.classList.remove('hidden');
            albumCover.classList.toggle('hidden', !track.cover_image);
            audioPlayer.classList.remove('hidden');
        }
        
        function playTrack(index) {
            currentTrackIndex = index;
            loadTrack(currentTrackIndex);
            audioPlayer.play();
            playPauseBtn.textContent = '||';
        }
        
        function togglePlayPause() {
            if (audioPlayer.paused) {
                audioPlayer.play();
                playPauseBtn.textContent = '||';
            } else {
                audioPlayer.pause();
                playPauseBtn.textContent = '▶️';
            }
        }
        
        function prevTrack() {
            currentTrackIndex = (currentTrackIndex - 1 + tracks.length) % tracks.length;
            playTrack(currentTrackIndex);
        }

        function nextTrack() {
            currentTrackIndex = (currentTrackIndex + 1) % tracks.length;
            playTrack(currentTrackIndex);
        }

        function seekTrack() {
            audioPlayer.currentTime = seekBar.value;
        }

        function changeVolume() {
            audioPlayer.volume = volumeBar.value / 100;
        }
        
        // Update seek bar as track plays
        audioPlayer.ontimeupdate = function() {
            seekBar.value = audioPlayer.currentTime;
        };

        // Update the max value of the seek bar based on the duration of the audio
        audioPlayer.onloadedmetadata = function() {
            seekBar.max = audioPlayer.duration;
        };
    </script>
</x-app-layout>
