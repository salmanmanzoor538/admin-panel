<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Range;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Media Player Page - Advanced audio and video player with context menu
 * Features: Sound & video player, right-click context menu, playlist management
 */
class MediaPlayerPage extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-play';
    
    protected static string $view = 'filament.pages.media-player-page';
    
    protected static ?string $title = 'Media Player';
    
    protected static ?string $navigationLabel = 'Media Player';
    
    protected static ?int $navigationSort = 10;
    
    protected static ?string $navigationGroup = 'Media';
    
    public ?array $data = [];
    public ?string $activeTab = 'player';
    public ?array $playlist = [];
    public ?array $currentTrack = null;
    public ?bool $isPlaying = false;
    public ?float $currentTime = 0;
    public ?float $duration = 0;
    public ?float $volume = 0.8;
    public ?bool $isMuted = false;
    public ?bool $isShuffled = false;
    public ?bool $isRepeating = false;
    public ?string $playMode = 'normal'; // normal, shuffle, repeat
    
    public function mount(): void
    {
        $this->form->fill();
        $this->loadPlaylist();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Media Player')
                    ->tabs([
                        Tabs\Tab::make('Player')
                            ->schema([
                                Section::make('Now Playing')
                                    ->schema([
                                        Placeholder::make('now_playing')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="now-playing">
                                                    <!-- Now playing will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Player Controls')
                                    ->schema([
                                        Placeholder::make('player_controls')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="player-controls">
                                                    <!-- Player controls will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Progress Bar')
                                    ->schema([
                                        Placeholder::make('progress_bar')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="progress-bar">
                                                    <!-- Progress bar will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Volume Control')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Range::make('volume')
                                                    ->label('Volume')
                                                    ->min(0)
                                                    ->max(100)
                                                    ->step(1)
                                                    ->default(80)
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->updateVolume()),
                                                    
                                                Toggle::make('is_muted')
                                                    ->label('Mute')
                                                    ->default(false)
                                                    ->live()
                                                    ->afterStateUpdated(fn() => $this->toggleMute()),
                                            ]),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Playlist')
                            ->schema([
                                Section::make('Playlist Management')
                                    ->schema([
                                        FileUpload::make('media_files')
                                            ->label('Upload Media Files')
                                            ->acceptedFileTypes(['audio/*', 'video/*'])
                                            ->multiple()
                                            ->directory('media')
                                            ->visibility('public')
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updatePlaylist()),
                                            
                                        Placeholder::make('playlist_display')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="playlist-display">
                                                    <!-- Playlist will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Settings')
                            ->schema([
                                Section::make('Player Settings')
                                    ->schema([
                                        Select::make('play_mode')
                                            ->label('Play Mode')
                                            ->options([
                                                'normal' => 'Normal',
                                                'shuffle' => 'Shuffle',
                                                'repeat' => 'Repeat',
                                                'repeat_one' => 'Repeat One',
                                            ])
                                            ->default('normal')
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updatePlayMode()),
                                            
                                        Toggle::make('auto_play')
                                            ->label('Auto Play')
                                            ->default(false)
                                            ->helperText('Automatically start playing when a track is selected'),
                                            
                                        Toggle::make('crossfade')
                                            ->label('Crossfade')
                                            ->default(false)
                                            ->helperText('Smooth transition between tracks'),
                                            
                                        Range::make('crossfade_duration')
                                            ->label('Crossfade Duration')
                                            ->min(1)
                                            ->max(10)
                                            ->step(1)
                                            ->default(3)
                                            ->visible(fn($get) => $get('crossfade'))
                                            ->suffix('seconds'),
                                    ]),
                                    
                                Section::make('Audio Settings')
                                    ->schema([
                                        Select::make('audio_quality')
                                            ->label('Audio Quality')
                                            ->options([
                                                'low' => 'Low (128 kbps)',
                                                'medium' => 'Medium (256 kbps)',
                                                'high' => 'High (320 kbps)',
                                                'lossless' => 'Lossless (FLAC)',
                                            ])
                                            ->default('high')
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateAudioQuality()),
                                            
                                        Toggle::make('equalizer')
                                            ->label('Enable Equalizer')
                                            ->default(false)
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->toggleEqualizer()),
                                            
                                        Placeholder::make('equalizer_controls')
                                            ->label('Equalizer')
                                            ->visible(fn($get) => $get('equalizer'))
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="equalizer-controls">
                                                    <!-- Equalizer will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Visualizer')
                            ->schema([
                                Section::make('Audio Visualizer')
                                    ->schema([
                                        Placeholder::make('visualizer')
                                            ->label('')
                                            ->content(new \Illuminate\Support\HtmlString('
                                                <div id="visualizer">
                                                    <!-- Visualizer will be rendered here -->
                                                </div>
                                            ')),
                                    ]),
                                    
                                Section::make('Visualizer Settings')
                                    ->schema([
                                        Select::make('visualizer_type')
                                            ->label('Visualizer Type')
                                            ->options([
                                                'bars' => 'Bars',
                                                'circle' => 'Circle',
                                                'wave' => 'Wave',
                                                'spectrum' => 'Spectrum',
                                                'particles' => 'Particles',
                                            ])
                                            ->default('bars')
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->updateVisualizerType()),
                                            
                                        Toggle::make('visualizer_enabled')
                                            ->label('Enable Visualizer')
                                            ->default(true)
                                            ->live()
                                            ->afterStateUpdated(fn() => $this->toggleVisualizer()),
                                            
                                        Range::make('visualizer_sensitivity')
                                            ->label('Sensitivity')
                                            ->min(0.1)
                                            ->max(2.0)
                                            ->step(0.1)
                                            ->default(1.0)
                                            ->visible(fn($get) => $get('visualizer_enabled')),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('play_pause')
                ->label(fn() => $this->isPlaying ? 'Pause' : 'Play')
                ->icon(fn() => $this->isPlaying ? 'heroicon-o-pause' : 'heroicon-o-play')
                ->color('primary')
                ->action('togglePlayPause'),
                
            Action::make('stop')
                ->label('Stop')
                ->icon('heroicon-o-stop')
                ->color('gray')
                ->action('stop'),
                
            Action::make('previous')
                ->label('Previous')
                ->icon('heroicon-o-backward')
                ->color('gray')
                ->action('previousTrack'),
                
            Action::make('next')
                ->label('Next')
                ->icon('heroicon-o-forward')
                ->color('gray')
                ->action('nextTrack'),
        ];
    }
    
    protected function loadPlaylist(): void
    {
        $this->playlist = [
            [
                'id' => 1,
                'title' => 'Sample Song 1',
                'artist' => 'Artist 1',
                'album' => 'Album 1',
                'duration' => 180,
                'file_path' => '/media/sample1.mp3',
                'cover_art' => '/images/cover1.jpg',
                'genre' => 'Pop',
                'year' => 2024,
            ],
            [
                'id' => 2,
                'title' => 'Sample Song 2',
                'artist' => 'Artist 2',
                'album' => 'Album 2',
                'duration' => 240,
                'file_path' => '/media/sample2.mp3',
                'cover_art' => '/images/cover2.jpg',
                'genre' => 'Rock',
                'year' => 2024,
            ],
            [
                'id' => 3,
                'title' => 'Sample Song 3',
                'artist' => 'Artist 3',
                'album' => 'Album 3',
                'duration' => 200,
                'file_path' => '/media/sample3.mp3',
                'cover_art' => '/images/cover3.jpg',
                'genre' => 'Electronic',
                'year' => 2024,
            ],
        ];
        
        $this->currentTrack = $this->playlist[0] ?? null;
    }
    
    public function updateVolume(): void
    {
        Notification::make()
            ->title('Volume updated')
            ->success()
            ->send();
    }
    
    public function toggleMute(): void
    {
        $this->isMuted = !$this->isMuted;
        Notification::make()
            ->title($this->isMuted ? 'Muted' : 'Unmuted')
            ->success()
            ->send();
    }
    
    public function updatePlaylist(): void
    {
        Notification::make()
            ->title('Playlist updated')
            ->success()
            ->send();
    }
    
    public function updatePlayMode(): void
    {
        Notification::make()
            ->title('Play mode updated')
            ->success()
            ->send();
    }
    
    public function updateAudioQuality(): void
    {
        Notification::make()
            ->title('Audio quality updated')
            ->success()
            ->send();
    }
    
    public function toggleEqualizer(): void
    {
        Notification::make()
            ->title('Equalizer toggled')
            ->success()
            ->send();
    }
    
    public function updateVisualizerType(): void
    {
        Notification::make()
            ->title('Visualizer type updated')
            ->success()
            ->send();
    }
    
    public function toggleVisualizer(): void
    {
        Notification::make()
            ->title('Visualizer toggled')
            ->success()
            ->send();
    }
    
    public function togglePlayPause(): void
    {
        $this->isPlaying = !$this->isPlaying;
        Notification::make()
            ->title($this->isPlaying ? 'Playing' : 'Paused')
            ->success()
            ->send();
    }
    
    public function stop(): void
    {
        $this->isPlaying = false;
        $this->currentTime = 0;
        Notification::make()
            ->title('Stopped')
            ->success()
            ->send();
    }
    
    public function previousTrack(): void
    {
        $currentIndex = array_search($this->currentTrack, $this->playlist);
        if ($currentIndex > 0) {
            $this->currentTrack = $this->playlist[$currentIndex - 1];
            Notification::make()
                ->title('Previous track')
                ->success()
                ->send();
        }
    }
    
    public function nextTrack(): void
    {
        $currentIndex = array_search($this->currentTrack, $this->playlist);
        if ($currentIndex < count($this->playlist) - 1) {
            $this->currentTrack = $this->playlist[$currentIndex + 1];
            Notification::make()
                ->title('Next track')
                ->success()
                ->send();
        }
    }
    
    public function playTrack(int $trackId): void
    {
        $track = collect($this->playlist)->firstWhere('id', $trackId);
        if ($track) {
            $this->currentTrack = $track;
            $this->isPlaying = true;
            Notification::make()
                ->title('Now playing: ' . $track['title'])
                ->success()
                ->send();
        }
    }
    
    public function removeFromPlaylist(int $trackId): void
    {
        $this->playlist = array_filter($this->playlist, fn($track) => $track['id'] !== $trackId);
        Notification::make()
            ->title('Track removed from playlist')
            ->success()
            ->send();
    }
    
    public function addToFavorites(int $trackId): void
    {
        Notification::make()
            ->title('Added to favorites')
            ->success()
            ->send();
    }
    
    public function showTrackInfo(int $trackId): void
    {
        $track = collect($this->playlist)->firstWhere('id', $trackId);
        if ($track) {
            Notification::make()
                ->title('Track Info')
                ->body("Title: {$track['title']}\nArtist: {$track['artist']}\nAlbum: {$track['album']}")
                ->info()
                ->send();
        }
    }
}