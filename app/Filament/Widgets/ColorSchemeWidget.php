<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Color Scheme Widget - Theme customization with 10+ color schemes
 * Features: Light/Dark mode, multiple color schemes, real-time preview
 */
class ColorSchemeWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    
    protected static string $view = 'filament.widgets.color-scheme-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 10;
    
    public ?string $colorScheme = 'blue';
    public ?string $themeMode = 'light';
    
    protected function getViewData(): array
    {
        return [
            'colorScheme' => $this->colorScheme,
            'themeMode' => $this->themeMode,
            'colorSchemes' => $this->getColorSchemes(),
            'themeModes' => $this->getThemeModes(),
        ];
    }
    
    protected function getColorSchemes(): array
    {
        return [
            'blue' => [
                'name' => 'Blue',
                'primary' => '#3b82f6',
                'secondary' => '#1e40af',
                'accent' => '#60a5fa',
                'preview' => 'bg-blue-500',
            ],
            'green' => [
                'name' => 'Green',
                'primary' => '#10b981',
                'secondary' => '#047857',
                'accent' => '#34d399',
                'preview' => 'bg-green-500',
            ],
            'purple' => [
                'name' => 'Purple',
                'primary' => '#8b5cf6',
                'secondary' => '#7c3aed',
                'accent' => '#a78bfa',
                'preview' => 'bg-purple-500',
            ],
            'red' => [
                'name' => 'Red',
                'primary' => '#ef4444',
                'secondary' => '#dc2626',
                'accent' => '#f87171',
                'preview' => 'bg-red-500',
            ],
            'yellow' => [
                'name' => 'Yellow',
                'primary' => '#f59e0b',
                'secondary' => '#d97706',
                'accent' => '#fbbf24',
                'preview' => 'bg-yellow-500',
            ],
            'pink' => [
                'name' => 'Pink',
                'primary' => '#ec4899',
                'secondary' => '#db2777',
                'accent' => '#f472b6',
                'preview' => 'bg-pink-500',
            ],
            'indigo' => [
                'name' => 'Indigo',
                'primary' => '#6366f1',
                'secondary' => '#4f46e5',
                'accent' => '#818cf8',
                'preview' => 'bg-indigo-500',
            ],
            'teal' => [
                'name' => 'Teal',
                'primary' => '#14b8a6',
                'secondary' => '#0d9488',
                'accent' => '#5eead4',
                'preview' => 'bg-teal-500',
            ],
            'orange' => [
                'name' => 'Orange',
                'primary' => '#f97316',
                'secondary' => '#ea580c',
                'accent' => '#fb923c',
                'preview' => 'bg-orange-500',
            ],
            'cyan' => [
                'name' => 'Cyan',
                'primary' => '#06b6d4',
                'secondary' => '#0891b2',
                'accent' => '#67e8f9',
                'preview' => 'bg-cyan-500',
            ],
            'emerald' => [
                'name' => 'Emerald',
                'primary' => '#059669',
                'secondary' => '#047857',
                'accent' => '#6ee7b7',
                'preview' => 'bg-emerald-500',
            ],
            'rose' => [
                'name' => 'Rose',
                'primary' => '#f43f5e',
                'secondary' => '#e11d48',
                'accent' => '#fb7185',
                'preview' => 'bg-rose-500',
            ],
        ];
    }
    
    protected function getThemeModes(): array
    {
        return [
            'light' => [
                'name' => 'Light Mode',
                'icon' => 'fas fa-sun',
                'description' => 'Clean and bright interface',
            ],
            'dark' => [
                'name' => 'Dark Mode',
                'icon' => 'fas fa-moon',
                'description' => 'Easy on the eyes',
            ],
            'auto' => [
                'name' => 'Auto',
                'icon' => 'fas fa-adjust',
                'description' => 'Follows system preference',
            ],
        ];
    }
    
    public function getFormSchema(): array
    {
        return [
            Select::make('colorScheme')
                ->label('Color Scheme')
                ->options(collect($this->getColorSchemes())->mapWithKeys(fn($scheme, $key) => [$key => $scheme['name']]))
                ->live()
                ->afterStateUpdated(fn() => $this->applyColorScheme()),
                
            Select::make('themeMode')
                ->label('Theme Mode')
                ->options(collect($this->getThemeModes())->mapWithKeys(fn($mode, $key) => [$key => $mode['name']]))
                ->live()
                ->afterStateUpdated(fn() => $this->applyThemeMode()),
        ];
    }
    
    public function applyColorScheme(): void
    {
        // In a real application, this would update the CSS variables or theme
        session(['color_scheme' => $this->colorScheme]);
        
        Notification::make()
            ->title('Color scheme updated')
            ->success()
            ->send();
    }
    
    public function applyThemeMode(): void
    {
        // In a real application, this would toggle dark/light mode
        session(['theme_mode' => $this->themeMode]);
        
        Notification::make()
            ->title('Theme mode updated')
            ->success()
            ->send();
    }
    
    public function resetToDefault(): void
    {
        $this->colorScheme = 'blue';
        $this->themeMode = 'light';
        $this->applyColorScheme();
        $this->applyThemeMode();
    }
}