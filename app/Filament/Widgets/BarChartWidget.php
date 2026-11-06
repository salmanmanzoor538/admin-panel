<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Category;
use Filament\Widgets\ChartWidget;

/**
 * Bar Chart Widget for displaying category-wise post distribution
 * Features: Dynamic data binding, responsive design, color-coded categories
 */
class BarChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Posts by Category';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public ?string $filter = 'all';

    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Time',
            '30d' => 'Last 30 days',
            '90d' => 'Last 90 days',
            '1y' => 'Last year',
        ];
    }

    protected function getData(): array
    {
        $categories = Category::withCount(['posts' => function ($query) {
            match ($this->filter) {
                '30d' => $query->where('created_at', '>=', now()->subDays(30)),
                '90d' => $query->where('created_at', '>=', now()->subDays(90)),
                '1y' => $query->where('created_at', '>=', now()->subYear()),
                default => null,
            };
        }])->get();

        // Generate colors for each category
        $colors = [
            'rgb(239, 68, 68)',   // Red
            'rgb(34, 197, 94)',   // Green
            'rgb(59, 130, 246)',  // Blue
            'rgb(168, 85, 247)',  // Purple
            'rgb(245, 158, 11)',  // Yellow
            'rgb(236, 72, 153)',  // Pink
            'rgb(14, 165, 233)',  // Sky
            'rgb(34, 197, 94)',   // Emerald
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Posts Count',
                    'data' => $categories->pluck('posts_count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $categories->count()),
                    'borderColor' => array_slice($colors, 0, $categories->count()),
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $categories->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return context.label + ": " + context.parsed.y + " posts";
                        }'
                    ]
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Categories'
                    ]
                ],
                'y' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Posts'
                    ],
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}