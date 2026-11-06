<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

/**
 * Advanced Charts Widget - Integration with multiple chart libraries
 * Features: ApexCharts, Recharts, C3, AmCharts with real-time data
 */
class AdvancedChartsWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    
    protected static string $view = 'filament.widgets.advanced-charts-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 12;
    
    public ?string $chartLibrary = 'apexcharts';
    public ?string $chartType = 'line';
    public ?string $theme = 'light';
    public ?bool $realTime = false;
    public ?bool $animations = true;
    public ?string $primaryColor = '#3b82f6';
    public ?string $secondaryColor = '#10b981';
    
    protected function getViewData(): array
    {
        return [
            'chartLibrary' => $this->chartLibrary,
            'chartType' => $this->chartType,
            'theme' => $this->theme,
            'realTime' => $this->realTime,
            'animations' => $this->animations,
            'primaryColor' => $this->primaryColor,
            'secondaryColor' => $this->secondaryColor,
            'chartLibraries' => $this->getChartLibraries(),
            'chartTypes' => $this->getChartTypes(),
            'themes' => $this->getThemes(),
            'sampleData' => $this->getSampleData(),
        ];
    }
    
    protected function getChartLibraries(): array
    {
        return [
            'apexcharts' => [
                'name' => 'ApexCharts',
                'description' => 'Modern charting library with beautiful animations',
                'icon' => 'fas fa-chart-line',
                'features' => ['Responsive', 'Interactive', 'Animations', 'Themes'],
            ],
            'recharts' => [
                'name' => 'Recharts',
                'description' => 'Composable charting library built on React',
                'icon' => 'fas fa-chart-bar',
                'features' => ['Composable', 'Responsive', 'Customizable', 'SVG-based'],
            ],
            'c3' => [
                'name' => 'C3.js',
                'description' => 'D3-based reusable chart library',
                'icon' => 'fas fa-chart-pie',
                'features' => ['D3-based', 'Reusable', 'Lightweight', 'Configurable'],
            ],
            'amcharts' => [
                'name' => 'AmCharts',
                'description' => 'Advanced charting library with rich features',
                'icon' => 'fas fa-chart-area',
                'features' => ['Advanced', 'Rich Features', 'Performance', 'Customizable'],
            ],
        ];
    }
    
    protected function getChartTypes(): array
    {
        return [
            'line' => [
                'name' => 'Line Chart',
                'description' => 'Perfect for showing trends over time',
                'icon' => 'fas fa-chart-line',
            ],
            'bar' => [
                'name' => 'Bar Chart',
                'description' => 'Great for comparing categories',
                'icon' => 'fas fa-chart-bar',
            ],
            'pie' => [
                'name' => 'Pie Chart',
                'description' => 'Ideal for showing proportions',
                'icon' => 'fas fa-chart-pie',
            ],
            'area' => [
                'name' => 'Area Chart',
                'description' => 'Shows magnitude of change over time',
                'icon' => 'fas fa-chart-area',
            ],
            'scatter' => [
                'name' => 'Scatter Plot',
                'description' => 'Shows relationship between two variables',
                'icon' => 'fas fa-dot-circle',
            ],
            'radar' => [
                'name' => 'Radar Chart',
                'description' => 'Multi-dimensional data visualization',
                'icon' => 'fas fa-bullseye',
            ],
            'heatmap' => [
                'name' => 'Heatmap',
                'description' => 'Shows data density and patterns',
                'icon' => 'fas fa-th',
            ],
            'candlestick' => [
                'name' => 'Candlestick',
                'description' => 'Financial data visualization',
                'icon' => 'fas fa-chart-line',
            ],
        ];
    }
    
    protected function getThemes(): array
    {
        return [
            'light' => [
                'name' => 'Light Theme',
                'description' => 'Clean and bright appearance',
                'preview' => 'bg-white',
            ],
            'dark' => [
                'name' => 'Dark Theme',
                'description' => 'Dark mode for better visibility',
                'preview' => 'bg-gray-800',
            ],
            'colorful' => [
                'name' => 'Colorful Theme',
                'description' => 'Vibrant and colorful appearance',
                'preview' => 'bg-gradient-to-r from-blue-500 to-purple-600',
            ],
            'minimal' => [
                'name' => 'Minimal Theme',
                'description' => 'Simple and clean design',
                'preview' => 'bg-gray-100',
            ],
        ];
    }
    
    protected function getSampleData(): array
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'name' => 'Sales',
                    'data' => [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 32000, 40000, 38000, 45000],
                    'color' => '#3b82f6',
                ],
                [
                    'name' => 'Revenue',
                    'data' => [8000, 12000, 10000, 18000, 16000, 22000, 20000, 25000, 23000, 28000, 26000, 30000],
                    'color' => '#10b981',
                ],
                [
                    'name' => 'Profit',
                    'data' => [4000, 7000, 5000, 7000, 6000, 8000, 8000, 10000, 9000, 12000, 12000, 15000],
                    'color' => '#f59e0b',
                ],
            ],
        ];
    }
    
    public function getFormSchema(): array
    {
        return [
            Section::make('Chart Configuration')
                ->schema([
                    Select::make('chartLibrary')
                        ->label('Chart Library')
                        ->options(collect($this->getChartLibraries())->mapWithKeys(fn($lib, $key) => [$key => $lib['name']]))
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateChart()),
                        
                    Select::make('chartType')
                        ->label('Chart Type')
                        ->options(collect($this->getChartTypes())->mapWithKeys(fn($type, $key) => [$key => $type['name']]))
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateChart()),
                        
                    Select::make('theme')
                        ->label('Theme')
                        ->options(collect($this->getThemes())->mapWithKeys(fn($theme, $key) => [$key => $theme['name']]))
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateChart()),
                ])
                ->columns(3),
                
            Section::make('Chart Options')
                ->schema([
                    Toggle::make('realTime')
                        ->label('Real-time Updates')
                        ->live()
                        ->afterStateUpdated(fn() => $this->toggleRealTime()),
                        
                    Toggle::make('animations')
                        ->label('Enable Animations')
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateChart()),
                        
                    ColorPicker::make('primaryColor')
                        ->label('Primary Color')
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateChart()),
                        
                    ColorPicker::make('secondaryColor')
                        ->label('Secondary Color')
                        ->live()
                        ->afterStateUpdated(fn() => $this->updateChart()),
                ])
                ->columns(2),
        ];
    }
    
    public function updateChart(): void
    {
        $this->dispatch('chart-updated', [
            'library' => $this->chartLibrary,
            'type' => $this->chartType,
            'theme' => $this->theme,
            'animations' => $this->animations,
            'primaryColor' => $this->primaryColor,
            'secondaryColor' => $this->secondaryColor,
        ]);
        
        Notification::make()
            ->title('Chart updated')
            ->success()
            ->send();
    }
    
    public function toggleRealTime(): void
    {
        if ($this->realTime) {
            $this->dispatch('start-real-time');
        } else {
            $this->dispatch('stop-real-time');
        }
        
        Notification::make()
            ->title('Real-time updates ' . ($this->realTime ? 'enabled' : 'disabled'))
            ->success()
            ->send();
    }
    
    public function exportChart(): void
    {
        $this->dispatch('export-chart');
        
        Notification::make()
            ->title('Chart exported successfully')
            ->success()
            ->send();
    }
    
    public function refreshData(): void
    {
        $this->dispatch('refresh-chart-data');
        
        Notification::make()
            ->title('Chart data refreshed')
            ->success()
            ->send();
    }
}