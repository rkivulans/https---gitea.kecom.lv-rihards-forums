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
                    <img id="albumCover" src="" alt="Album Cover" class="w-48 h-48 object-contain mb-4">
                    <p id="trackTitle" class="text-white text-lg font-bold mb-2"></p>
                    <p id="trackArtist" class="text-gray-400 text-sm mb-4"></p>

                    <div class="flex items-center space-x-4 mb-4">
                        <!-- Custom Player Controls without background -->
                        <button onclick="prevTrack()" class="text-white hover:text-teal-400 transition">
                            ⏮️
                        </button>
                        <button onclick="togglePlayPause()" class="text-white hover:text-teal-400 transition" id="playPauseBtn">
                            ▶️
                        </button>
                        <button onclick="nextTrack()" class="text-white hover:text-teal-400 transition">
                            ⏭️
                        </button>
                    </div>

                    <!-- Time Display -->
                    <div class="flex justify-between w-full text-white text-sm">
                        <span id="currentTime">0:00</span>
                        <span id="totalTime">0:00</span>
                    </div>

                    <!-- Custom Time Seek Bar -->
                    <div class="flex items-center space-x-2 w-full mb-4">
                        <input type="range" id="seekBar" class="w-full bg-gray-700 appearance-none h-1 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500" value="0" max="100" onchange="seekTrack()" style="accent-color: red;">
                    </div>

                    <!-- Volume Control -->
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
        const audioPlayer = new Audio();
        const trackTitle = document.getElementById('trackTitle');
        const trackArtist = document.getElementById('trackArtist');
        const albumCover = document.getElementById('albumCover');
        const seekBar = document.getElementById('seekBar');
        const volumeBar = document.getElementById('volumeBar');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const currentTimeDisplay = document.getElementById('currentTime');  // Jauns elements, kas rāda pašreizējo laiku
        const totalTimeDisplay = document.getElementById('totalTime');  // Jauns elements, kas rāda kopējo dziesmas laiku

        let currentTrackIndex = 0;
        let isPlaying = false;  // To track if a song is playing

        // Load the first track when the page loads
        window.onload = function () {
            loadTrack(currentTrackIndex);
        };

        function loadTrack(index) {
            const track = tracks[index];
            audioPlayer.src = "{{ asset('') }}" + track.file_path;

            trackTitle.textContent = track.title;
            trackArtist.textContent = track.artist;
            albumCover.src = track.cover_image ? "{{ asset('') }}" + track.cover_image : '';

            trackTitle.classList.remove('hidden');
            trackArtist.classList.remove('hidden');
            albumCover.classList.toggle('hidden', !track.cover_image);

            audioPlayer.load();
        }

        function playTrack(index) {
            currentTrackIndex = index;
            loadTrack(currentTrackIndex);
            audioPlayer.play();
            isPlaying = true;
            playPauseBtn.textContent = '⏸️';
        }

        // Play the first track if no track has been selected yet
        function togglePlayPause() {
            if (!isPlaying) {
                playTrack(currentTrackIndex);  // Play the first track if none is playing
            } else {
                if (audioPlayer.paused) {
                    audioPlayer.play();
                    playPauseBtn.textContent = '⏸️';
                } else {
                    audioPlayer.pause();
                    playPauseBtn.textContent = '▶️';
                }
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
            const seekValue = seekBar.value;
            audioPlayer.currentTime = (seekValue / 100) * audioPlayer.duration;
        }

        function changeVolume() {
            audioPlayer.volume = volumeBar.value / 100;
        }

        // Pārtīšanas funkcionalitāte
        seekBar.addEventListener('input', function () {
            const seekValue = seekBar.value;
            audioPlayer.currentTime = (seekValue / 100) * audioPlayer.duration;
        });

        // Update seek bar as track plays
        audioPlayer.ontimeupdate = function () {
            seekBar.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;

            // Atjaunināt pašreizējo laiku
            currentTimeDisplay.textContent = formatTime(audioPlayer.currentTime);
        };

        // Update the max value of the seek bar based on the duration of the audio
        audioPlayer.onloadedmetadata = function () {
            seekBar.max = 100;  // To ensure it works on percentage scale
            totalTimeDisplay.textContent = formatTime(audioPlayer.duration);  // Rādīt kopējo dziesmas ilgumu
        };

        // Formatēt laiku (minūtes:sekundes)
        function formatTime(time) {
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }
    </script>
</x-app-layout>
