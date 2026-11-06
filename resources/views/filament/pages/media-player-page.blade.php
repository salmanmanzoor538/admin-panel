<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Media Player</h1>
                    <p class="text-gray-600 mt-1">Advanced audio and video player with context menu and visualizer</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Now Playing:</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            {{ $currentTrack['title'] ?? 'No track selected' }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Status:</span>
                        <span class="px-3 py-1 {{ $isPlaying ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} rounded-full text-sm font-medium">
                            {{ $isPlaying ? 'Playing' : 'Paused' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Player Interface -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Album Art -->
                <div class="lg:col-span-1">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        @if($currentTrack && isset($currentTrack['cover_art']))
                            <img src="{{ $currentTrack['cover_art'] }}" alt="{{ $currentTrack['title'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-music text-6xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Player Info and Controls -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <!-- Track Info -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $currentTrack['title'] ?? 'No track selected' }}</h2>
                            <p class="text-lg text-gray-600">{{ $currentTrack['artist'] ?? 'Unknown artist' }}</p>
                            <p class="text-sm text-gray-500">{{ $currentTrack['album'] ?? 'Unknown album' }} • {{ $currentTrack['year'] ?? 'Unknown year' }}</p>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-500">
                                <span id="current-time">{{ gmdate('i:s', $currentTime) }}</span>
                                <span id="total-time">{{ gmdate('i:s', $currentTrack['duration'] ?? 0) }}</span>
                            </div>
                            <div class="relative">
                                <input type="range" id="progress-slider" min="0" max="{{ $currentTrack['duration'] ?? 0 }}" value="{{ $currentTime }}" 
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                                <div class="absolute top-0 left-0 h-2 bg-blue-500 rounded-lg" 
                                     style="width: {{ $currentTrack['duration'] ? ($currentTime / $currentTrack['duration']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Player Controls -->
                        <div class="flex items-center justify-center space-x-4">
                            <button onclick="toggleShuffle()" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas fa-random text-lg {{ $isShuffled ? 'text-blue-500' : 'text-gray-400' }}"></i>
                            </button>
                            <button onclick="previousTrack()" class="p-3 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                <i class="fas fa-step-backward text-lg text-gray-700"></i>
                            </button>
                            <button onclick="togglePlayPause()" class="p-4 rounded-full bg-blue-500 hover:bg-blue-600 transition-colors">
                                <i class="fas {{ $isPlaying ? 'fa-pause' : 'fa-play' }} text-xl text-white"></i>
                            </button>
                            <button onclick="nextTrack()" class="p-3 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                <i class="fas fa-step-forward text-lg text-gray-700"></i>
                            </button>
                            <button onclick="toggleRepeat()" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas fa-redo text-lg {{ $isRepeating ? 'text-blue-500' : 'text-gray-400' }}"></i>
                            </button>
                        </div>
                        
                        <!-- Volume Control -->
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-volume-down text-gray-400"></i>
                            <input type="range" id="volume-slider" min="0" max="100" value="{{ $volume * 100 }}" 
                                   class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                            <i class="fas fa-volume-up text-gray-400"></i>
                            <button onclick="toggleMute()" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas {{ $isMuted ? 'fa-volume-mute' : 'fa-volume-up' }} text-gray-400"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audio Visualizer -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Audio Visualizer</h2>
            <div class="h-32 bg-gray-900 rounded-lg flex items-end justify-center space-x-1 p-4" id="visualizer">
                <!-- Visualizer bars will be rendered here -->
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{ $this->form }}
        </div>

        <!-- Playlist Display -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Playlist</h2>
            <div class="space-y-2" id="playlist-container">
                @foreach($playlist as $track)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer" 
                         onclick="playTrack({{ $track['id'] }})" 
                         oncontextmenu="showContextMenu(event, {{ $track['id'] }})">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-music text-gray-400"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $track['title'] }}</h3>
                                <p class="text-sm text-gray-500">{{ $track['artist'] }} • {{ $track['album'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">{{ gmdate('i:s', $track['duration']) }}</span>
                            @if($currentTrack && $currentTrack['id'] === $track['id'])
                                <i class="fas fa-play text-blue-500"></i>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Equalizer -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Equalizer</h2>
            <div class="grid grid-cols-10 gap-2" id="equalizer">
                @for($i = 0; $i < 10; $i++)
                    <div class="flex flex-col items-center space-y-2">
                        <span class="text-xs text-gray-500">{{ $i * 100 }}Hz</span>
                        <input type="range" min="-12" max="12" value="0" 
                               class="w-8 h-32 bg-gray-200 rounded-lg appearance-none cursor-pointer slider-vertical" 
                               orient="vertical">
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Context Menu -->
    <div id="context-menu" class="fixed bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50 hidden">
        <button onclick="playTrack(contextMenuTrackId)" class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center space-x-2">
            <i class="fas fa-play text-blue-500"></i>
            <span>Play</span>
        </button>
        <button onclick="addToFavorites(contextMenuTrackId)" class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center space-x-2">
            <i class="fas fa-heart text-red-500"></i>
            <span>Add to Favorites</span>
        </button>
        <button onclick="showTrackInfo(contextMenuTrackId)" class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center space-x-2">
            <i class="fas fa-info-circle text-blue-500"></i>
            <span>Track Info</span>
        </button>
        <hr class="my-1">
        <button onclick="removeFromPlaylist(contextMenuTrackId)" class="w-full px-4 py-2 text-left hover:bg-gray-100 flex items-center space-x-2 text-red-600">
            <i class="fas fa-trash"></i>
            <span>Remove from Playlist</span>
        </button>
    </div>

    <!-- Audio Element -->
    <audio id="audio-player" preload="metadata">
        <source src="{{ $currentTrack['file_path'] ?? '' }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <style>
        .slider {
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            cursor: pointer;
        }
        
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
        }
        
        .slider::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            border: none;
        }
        
        .slider-vertical {
            writing-mode: bt-lr;
            -webkit-appearance: slider-vertical;
        }
    </style>

    <script>
        // Media Player functionality
        let audioPlayer = null;
        let visualizerBars = [];
        let contextMenuTrackId = null;
        let isPlaying = @json($isPlaying);
        let currentTime = @json($currentTime);
        let duration = @json($currentTrack['duration'] ?? 0);
        let volume = @json($volume);
        let isMuted = @json($isMuted);
        let isShuffled = @json($isShuffled);
        let isRepeating = @json($isRepeating);
        let playlist = @json($playlist);
        let currentTrack = @json($currentTrack);
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeMediaPlayer();
        });
        
        function initializeMediaPlayer() {
            audioPlayer = document.getElementById('audio-player');
            setupAudioPlayer();
            setupVisualizer();
            setupKeyboardShortcuts();
            setupContextMenu();
            updatePlayerDisplay();
        }
        
        function setupAudioPlayer() {
            if (audioPlayer) {
                audioPlayer.addEventListener('loadedmetadata', function() {
                    duration = audioPlayer.duration;
                    updatePlayerDisplay();
                });
                
                audioPlayer.addEventListener('timeupdate', function() {
                    currentTime = audioPlayer.currentTime;
                    updatePlayerDisplay();
                });
                
                audioPlayer.addEventListener('ended', function() {
                    if (isRepeating) {
                        audioPlayer.currentTime = 0;
                        audioPlayer.play();
                    } else {
                        nextTrack();
                    }
                });
                
                audioPlayer.volume = volume;
                audioPlayer.muted = isMuted;
            }
        }
        
        function setupVisualizer() {
            const visualizer = document.getElementById('visualizer');
            const barCount = 32;
            
            for (let i = 0; i < barCount; i++) {
                const bar = document.createElement('div');
                bar.className = 'bg-blue-500 w-2 rounded-t';
                bar.style.height = '4px';
                visualizer.appendChild(bar);
                visualizerBars.push(bar);
            }
            
            // Simulate audio visualization
            setInterval(updateVisualizer, 100);
        }
        
        function updateVisualizer() {
            if (isPlaying) {
                visualizerBars.forEach((bar, index) => {
                    const height = Math.random() * 100 + 10;
                    bar.style.height = height + 'px';
                    bar.style.backgroundColor = `hsl(${200 + height}, 70%, 50%)`;
                });
            } else {
                visualizerBars.forEach(bar => {
                    bar.style.height = '4px';
                    bar.style.backgroundColor = '#3b82f6';
                });
            }
        }
        
        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                switch(e.code) {
                    case 'Space':
                        e.preventDefault();
                        togglePlayPause();
                        break;
                    case 'ArrowLeft':
                        e.preventDefault();
                        seekBackward();
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        seekForward();
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        increaseVolume();
                        break;
                    case 'ArrowDown':
                        e.preventDefault();
                        decreaseVolume();
                        break;
                    case 'KeyM':
                        e.preventDefault();
                        toggleMute();
                        break;
                    case 'KeyS':
                        e.preventDefault();
                        toggleShuffle();
                        break;
                    case 'KeyR':
                        e.preventDefault();
                        toggleRepeat();
                        break;
                }
            });
        }
        
        function setupContextMenu() {
            document.addEventListener('click', function() {
                hideContextMenu();
            });
            
            document.addEventListener('contextmenu', function(e) {
                if (e.target.closest('#playlist-container')) {
                    e.preventDefault();
                }
            });
        }
        
        function togglePlayPause() {
            if (audioPlayer) {
                if (isPlaying) {
                    audioPlayer.pause();
                    isPlaying = false;
                } else {
                    audioPlayer.play();
                    isPlaying = true;
                }
                updatePlayerDisplay();
            }
        }
        
        function stop() {
            if (audioPlayer) {
                audioPlayer.pause();
                audioPlayer.currentTime = 0;
                isPlaying = false;
                updatePlayerDisplay();
            }
        }
        
        function previousTrack() {
            const currentIndex = playlist.findIndex(track => track.id === currentTrack.id);
            if (currentIndex > 0) {
                playTrack(playlist[currentIndex - 1].id);
            }
        }
        
        function nextTrack() {
            const currentIndex = playlist.findIndex(track => track.id === currentTrack.id);
            if (currentIndex < playlist.length - 1) {
                playTrack(playlist[currentIndex + 1].id);
            }
        }
        
        function playTrack(trackId) {
            const track = playlist.find(t => t.id === trackId);
            if (track) {
                currentTrack = track;
                if (audioPlayer) {
                    audioPlayer.src = track.file_path;
                    audioPlayer.load();
                    audioPlayer.play();
                    isPlaying = true;
                }
                updatePlayerDisplay();
                hideContextMenu();
            }
        }
        
        function toggleShuffle() {
            isShuffled = !isShuffled;
            updatePlayerDisplay();
        }
        
        function toggleRepeat() {
            isRepeating = !isRepeating;
            updatePlayerDisplay();
        }
        
        function toggleMute() {
            isMuted = !isMuted;
            if (audioPlayer) {
                audioPlayer.muted = isMuted;
            }
            updatePlayerDisplay();
        }
        
        function increaseVolume() {
            volume = Math.min(1, volume + 0.1);
            if (audioPlayer) {
                audioPlayer.volume = volume;
            }
            updatePlayerDisplay();
        }
        
        function decreaseVolume() {
            volume = Math.max(0, volume - 0.1);
            if (audioPlayer) {
                audioPlayer.volume = volume;
            }
            updatePlayerDisplay();
        }
        
        function seekForward() {
            if (audioPlayer) {
                audioPlayer.currentTime = Math.min(duration, audioPlayer.currentTime + 10);
            }
        }
        
        function seekBackward() {
            if (audioPlayer) {
                audioPlayer.currentTime = Math.max(0, audioPlayer.currentTime - 10);
            }
        }
        
        function updatePlayerDisplay() {
            // Update time display
            const currentTimeElement = document.getElementById('current-time');
            const totalTimeElement = document.getElementById('total-time');
            
            if (currentTimeElement) {
                currentTimeElement.textContent = formatTime(currentTime);
            }
            if (totalTimeElement) {
                totalTimeElement.textContent = formatTime(duration);
            }
            
            // Update progress bar
            const progressSlider = document.getElementById('progress-slider');
            if (progressSlider) {
                progressSlider.max = duration;
                progressSlider.value = currentTime;
            }
            
            // Update volume slider
            const volumeSlider = document.getElementById('volume-slider');
            if (volumeSlider) {
                volumeSlider.value = volume * 100;
            }
            
            // Update play/pause button
            const playButton = document.querySelector('[onclick="togglePlayPause()"] i');
            if (playButton) {
                playButton.className = `fas ${isPlaying ? 'fa-pause' : 'fa-play'} text-xl text-white`;
            }
            
            // Update shuffle button
            const shuffleButton = document.querySelector('[onclick="toggleShuffle()"] i');
            if (shuffleButton) {
                shuffleButton.className = `fas fa-random text-lg ${isShuffled ? 'text-blue-500' : 'text-gray-400'}`;
            }
            
            // Update repeat button
            const repeatButton = document.querySelector('[onclick="toggleRepeat()"] i');
            if (repeatButton) {
                repeatButton.className = `fas fa-redo text-lg ${isRepeating ? 'text-blue-500' : 'text-gray-400'}`;
            }
            
            // Update mute button
            const muteButton = document.querySelector('[onclick="toggleMute()"] i');
            if (muteButton) {
                muteButton.className = `fas ${isMuted ? 'fa-volume-mute' : 'fa-volume-up'} text-gray-400`;
            }
        }
        
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }
        
        function showContextMenu(event, trackId) {
            event.preventDefault();
            contextMenuTrackId = trackId;
            
            const contextMenu = document.getElementById('context-menu');
            contextMenu.style.left = event.pageX + 'px';
            contextMenu.style.top = event.pageY + 'px';
            contextMenu.classList.remove('hidden');
        }
        
        function hideContextMenu() {
            const contextMenu = document.getElementById('context-menu');
            contextMenu.classList.add('hidden');
        }
        
        function addToFavorites(trackId) {
            showNotification('Added to favorites', 'success');
            hideContextMenu();
        }
        
        function showTrackInfo(trackId) {
            const track = playlist.find(t => t.id === trackId);
            if (track) {
                showNotification(`Track Info: ${track.title} by ${track.artist}`, 'info');
            }
            hideContextMenu();
        }
        
        function removeFromPlaylist(trackId) {
            if (confirm('Are you sure you want to remove this track from the playlist?')) {
                showNotification('Track removed from playlist', 'success');
                hideContextMenu();
            }
        }
        
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                type === 'warning' ? 'bg-yellow-500' :
                'bg-blue-500'
            } text-white`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
        
        // Progress bar interaction
        document.addEventListener('DOMContentLoaded', function() {
            const progressSlider = document.getElementById('progress-slider');
            if (progressSlider) {
                progressSlider.addEventListener('input', function() {
                    if (audioPlayer) {
                        audioPlayer.currentTime = this.value;
                    }
                });
            }
            
            const volumeSlider = document.getElementById('volume-slider');
            if (volumeSlider) {
                volumeSlider.addEventListener('input', function() {
                    volume = this.value / 100;
                    if (audioPlayer) {
                        audioPlayer.volume = volume;
                    }
                });
            }
        });
    </script>
</x-filament-panels::page>