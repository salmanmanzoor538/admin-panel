<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PostsChart extends ChartWidget
{
    protected static ?string $heading = 'Posts Created Over Time';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public ?string $filter = '7d';

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
            '7d' => Trend::model(Post::class)
                ->between(
                    start: now()->subDays(7),
                    end: now(),
                )
                ->perDay()
                ->count(),
            '30d' => Trend::model(Post::class)
                ->between(
                    start: now()->subDays(30),
                    end: now(),
                )
                ->perDay()
                ->count(),
            '90d' => Trend::model(Post::class)
                ->between(
                    start: now()->subDays(90),
                    end: now(),
                )
                ->perDay()
                ->count(),
            '1y' => Trend::model(Post::class)
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
                    'label' => 'Posts Created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}