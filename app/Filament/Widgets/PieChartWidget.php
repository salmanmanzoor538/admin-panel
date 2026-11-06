<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use Filament\Widgets\ChartWidget;

/**
 * Pie/Donut Chart Widget for displaying user activity distribution
 * Features: Dynamic data binding, responsive design, donut style with customizable inner radius
 */
class PieChartWidget extends ChartWidget
{
    protected static ?string $heading = 'User Activity Distribution';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public ?string $chartType = 'doughnut';

    protected function getFilters(): ?array
    {
        return [
            'doughnut' => 'Donut Chart',
            'pie' => 'Pie Chart',
        ];
    }

    protected function getData(): array
    {
        // Get user statistics
        $totalUsers = User::count();
        $activeUsers = User::where('created_at', '>=', now()->subDays(30))->count();
        $inactiveUsers = $totalUsers - $activeUsers;
        
        // Get post statistics
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts = Post::where('status', 'draft')->count();

        return [
            'datasets' => [
                [
                    'label' => 'User Activity',
                    'data' => [
                        $activeUsers,
                        $inactiveUsers,
                        $publishedPosts,
                        $draftPosts,
                    ],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)',   // Active users - Green
                        'rgb(156, 163, 175)', // Inactive users - Gray
                        'rgb(59, 130, 246)',  // Published posts - Blue
                        'rgb(245, 158, 11)',  // Draft posts - Yellow
                    ],
                    'borderColor' => [
                        'rgb(34, 197, 94)',
                        'rgb(156, 163, 175)',
                        'rgb(59, 130, 246)',
                        'rgb(245, 158, 11)',
                    ],
                    'borderWidth' => 2,
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => [
                'Active Users (30d)',
                'Inactive Users',
                'Published Posts',
                'Draft Posts',
            ],
        ];
    }

    protected function getType(): string
    {
        return $this->chartType ?? 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 20,
                        'usePointStyle' => true,
                    ],
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            const label = context.label || "";
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ": " + value + " (" + percentage + "%)";
                        }'
                    ]
                ],
            ],
            'cutout' => $this->chartType === 'doughnut' ? '60%' : 0,
            'elements' => [
                'arc' => [
                    'borderWidth' => 2,
                ],
            ],
        ];
    }
}