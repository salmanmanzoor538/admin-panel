<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

/**
 * Line Chart Widget for displaying user registration trends
 * Features: Dynamic data binding, responsive design, customizable time periods
 */
class LineChartWidget extends ChartWidget
{
    protected static ?string $heading = 'User Registration Trends';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public ?string $filter = '30d';

    protected function getFilters(): ?array
    {
        return [
            '7d' => 'Last 7 days',
            '30d' => 'Last 30 days',
            '90d' => 'Last 90 days',
            '1y' => 'Last year',
        ];
    }

    protected function getData(): array
    {
        $data = match ($this->filter) {
            '7d' => Trend::model(User::class)
                ->between(
                    start: now()->subDays(7),
                    end: now(),
                )
                ->perDay()
                ->count(),
            '30d' => Trend::model(User::class)
                ->between(
                    start: now()->subDays(30),
                    end: now(),
                )
                ->perDay()
                ->count(),
            '90d' => Trend::model(User::class)
                ->between(
                    start: now()->subDays(90),
                    end: now(),
                )
                ->perDay()
                ->count(),
            '1y' => Trend::model(User::class)
                ->between(
                    start: now()->subYear(),
                    end: now(),
                )
                ->perMonth()
                ->count(),
        };

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
                [
                    'label' => 'Posts Created',
                    'data' => Trend::model(Post::class)
                        ->between(
                            start: match ($this->filter) {
                                '7d' => now()->subDays(7),
                                '30d' => now()->subDays(30),
                                '90d' => now()->subDays(90),
                                '1y' => now()->subYear(),
                            },
                            end: now(),
                        )
                        ->perDay()
                        ->count()
                        ->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                    'fill' => false,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Time Period'
                    ]
                ],
                'y' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Count'
                    ],
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}