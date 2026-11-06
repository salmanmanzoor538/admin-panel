<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Keyboard Shortcuts Widget - Global navigation shortcuts
 * Features: Keyboard shortcuts for navigation, actions, and system controls
 */
class KeyboardShortcutsWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    
    protected static string $view = 'filament.widgets.keyboard-shortcuts-widget';
    
    protected static ?int $sort = 1;
    
    protected int | string | array $columnSpan = 'full';
    
    public ?array $data = [];
    public ?array $shortcuts = [];
    public ?bool $shortcutsEnabled = true;
    public ?string $activeShortcut = '';
    
    public function mount(): void
    {
        $this->form->fill();
        $this->loadShortcuts();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Keyboard Shortcuts Configuration')
                    ->schema([
                        Toggle::make('shortcuts_enabled')
                            ->label('Enable Keyboard Shortcuts')
                            ->default(true)
                            ->live()
                            ->afterStateUpdated(fn() => $this->toggleShortcuts()),
                            
                        Placeholder::make('shortcuts_display')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div id="shortcuts-display">
                                    <!-- Shortcuts will be rendered here -->
                                </div>
                            ')),
                    ]),
                    
                Section::make('Custom Shortcuts')
                    ->schema([
                        KeyValue::make('custom_shortcuts')
                            ->label('Add Custom Shortcuts')
                            ->keyLabel('Action')
                            ->valueLabel('Keyboard Combination')
                            ->addActionLabel('Add Shortcut')
                            ->live()
                            ->afterStateUpdated(fn() => $this->updateCustomShortcuts()),
                    ]),
            ])
            ->statePath('data');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('show_shortcuts')
                ->label('Show All Shortcuts')
                ->icon('heroicon-o-keyboard')
                ->color('primary')
                ->action('showShortcutsModal'),
                
            Action::make('reset_shortcuts')
                ->label('Reset to Default')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action('resetShortcuts'),
        ];
    }
    
    protected function loadShortcuts(): void
    {
        $this->shortcuts = [
            'navigation' => [
                'title' => 'Navigation',
                'shortcuts' => [
                    ['key' => 'Ctrl + /', 'action' => 'Show/Hide Shortcuts Help', 'description' => 'Toggle shortcuts help modal'],
                    ['key' => 'Ctrl + K', 'action' => 'Command Palette', 'description' => 'Open global command palette'],
                    ['key' => 'Ctrl + ,', 'action' => 'Settings', 'description' => 'Open settings page'],
                    ['key' => 'Alt + H', 'action' => 'Home Dashboard', 'description' => 'Navigate to home dashboard'],
                    ['key' => 'Alt + U', 'action' => 'Users', 'description' => 'Navigate to users page'],
                    ['key' => 'Alt + P', 'action' => 'Posts', 'description' => 'Navigate to posts page'],
                    ['key' => 'Alt + C', 'action' => 'Categories', 'description' => 'Navigate to categories page'],
                    ['key' => 'Alt + M', 'action' => 'Media', 'description' => 'Navigate to media page'],
                    ['key' => 'Alt + S', 'action' => 'Settings', 'description' => 'Navigate to settings page'],
                    ['key' => 'Alt + T', 'action' => 'Tools', 'description' => 'Navigate to tools page'],
                ]
            ],
            'actions' => [
                'title' => 'Actions',
                'shortcuts' => [
                    ['key' => 'Ctrl + N', 'action' => 'New Item', 'description' => 'Create new item in current section'],
                    ['key' => 'Ctrl + S', 'action' => 'Save', 'description' => 'Save current form or document'],
                    ['key' => 'Ctrl + Z', 'action' => 'Undo', 'description' => 'Undo last action'],
                    ['key' => 'Ctrl + Y', 'action' => 'Redo', 'description' => 'Redo last undone action'],
                    ['key' => 'Ctrl + A', 'action' => 'Select All', 'description' => 'Select all items in current view'],
                    ['key' => 'Ctrl + C', 'action' => 'Copy', 'description' => 'Copy selected items'],
                    ['key' => 'Ctrl + V', 'action' => 'Paste', 'description' => 'Paste copied items'],
                    ['key' => 'Ctrl + X', 'action' => 'Cut', 'description' => 'Cut selected items'],
                    ['key' => 'Delete', 'action' => 'Delete', 'description' => 'Delete selected items'],
                    ['key' => 'Ctrl + F', 'action' => 'Search', 'description' => 'Open search in current page'],
                ]
            ],
            'media' => [
                'title' => 'Media Player',
                'shortcuts' => [
                    ['key' => 'Space', 'action' => 'Play/Pause', 'description' => 'Toggle play/pause in media player'],
                    ['key' => '←', 'action' => 'Seek Backward', 'description' => 'Seek 10 seconds backward'],
                    ['key' => '→', 'action' => 'Seek Forward', 'description' => 'Seek 10 seconds forward'],
                    ['key' => '↑', 'action' => 'Volume Up', 'description' => 'Increase volume'],
                    ['key' => '↓', 'action' => 'Volume Down', 'description' => 'Decrease volume'],
                    ['key' => 'M', 'action' => 'Mute/Unmute', 'description' => 'Toggle mute'],
                    ['key' => 'S', 'action' => 'Shuffle', 'description' => 'Toggle shuffle mode'],
                    ['key' => 'R', 'action' => 'Repeat', 'description' => 'Toggle repeat mode'],
                ]
            ],
            'system' => [
                'title' => 'System',
                'shortcuts' => [
                    ['key' => 'F11', 'action' => 'Fullscreen', 'description' => 'Toggle fullscreen mode'],
                    ['key' => 'Ctrl + Shift + D', 'action' => 'Dark Mode', 'description' => 'Toggle dark/light theme'],
                    ['key' => 'Ctrl + Shift + R', 'action' => 'Refresh', 'description' => 'Refresh current page'],
                    ['key' => 'Ctrl + Shift + I', 'action' => 'Dev Tools', 'description' => 'Open developer tools'],
                    ['key' => 'Ctrl + Shift + P', 'action' => 'Print', 'description' => 'Print current page'],
                    ['key' => 'Escape', 'action' => 'Close Modal', 'description' => 'Close any open modal or dropdown'],
                ]
            ],
            'crypto' => [
                'title' => 'Crypto Exchange',
                'shortcuts' => [
                    ['key' => 'Ctrl + B', 'action' => 'Buy Order', 'description' => 'Open buy order form'],
                    ['key' => 'Ctrl + Shift + B', 'action' => 'Sell Order', 'description' => 'Open sell order form'],
                    ['key' => 'Ctrl + W', 'action' => 'Wallet', 'description' => 'Open wallet section'],
                    ['key' => 'Ctrl + O', 'action' => 'Orders', 'description' => 'View open orders'],
                    ['key' => 'Ctrl + T', 'action' => 'Trading Chart', 'description' => 'Focus on trading chart'],
                ]
            ],
        ];
    }
    
    public function toggleShortcuts(): void
    {
        $this->shortcutsEnabled = !$this->shortcutsEnabled;
        Notification::make()
            ->title($this->shortcutsEnabled ? 'Keyboard shortcuts enabled' : 'Keyboard shortcuts disabled')
            ->success()
            ->send();
    }
    
    public function updateCustomShortcuts(): void
    {
        Notification::make()
            ->title('Custom shortcuts updated')
            ->success()
            ->send();
    }
    
    public function showShortcutsModal(): void
    {
        Notification::make()
            ->title('Shortcuts Help')
            ->body('Press Ctrl + / to toggle shortcuts help')
            ->info()
            ->send();
    }
    
    public function resetShortcuts(): void
    {
        $this->loadShortcuts();
        Notification::make()
            ->title('Shortcuts reset to default')
            ->success()
            ->send();
    }
    
    public function executeShortcut(string $shortcut): void
    {
        $this->activeShortcut = $shortcut;
        Notification::make()
            ->title('Shortcut executed: ' . $shortcut)
            ->success()
            ->send();
    }
}