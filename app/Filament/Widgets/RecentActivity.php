<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Post;
use App\Models\Page;
use App\Modules\Ecommerce\Models\Order;
use App\Modules\LMS\Models\Course;
use App\Modules\CRM\Models\Client;
use App\Modules\CRM\Models\Deal;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentActivity extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getRecentActivityQuery())
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->defaultImageUrl(fn ($record): string => $record->avatar_url ?? ''),
                Tables\Columns\TextColumn::make('activity_type')
                    ->label('Activity')
                    ->badge()
                    ->color(fn (string $state): string => $this->getActivityColor($state)),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('user_name')
                    ->label('User'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->heading('Recent Activity')
            ->description('Latest activities across all modules');
    }

    protected function getRecentActivityQuery(): Builder
    {
        // Combine recent activities from different modules
        $activities = collect();

        // Recent posts
        $posts = Post::with('author')
            ->latest('created_at')
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return (object) [
                    'id' => 'post_' . $post->id,
                    'activity_type' => 'Post Created',
                    'description' => "Created post: {$post->title}",
                    'user_name' => $post->author->name ?? 'Unknown',
                    'avatar_url' => $post->author->avatar_url ?? '',
                    'created_at' => $post->created_at,
                ];
            });

        // Recent pages
        $pages = Page::with('author')
            ->latest('created_at')
            ->limit(5)
            ->get()
            ->map(function ($page) {
                return (object) [
                    'id' => 'page_' . $page->id,
                    'activity_type' => 'Page Created',
                    'description' => "Created page: {$page->title}",
                    'user_name' => $page->author->name ?? 'Unknown',
                    'avatar_url' => $page->author->avatar_url ?? '',
                    'created_at' => $page->created_at,
                ];
            });

        // Recent users
        $users = User::latest('created_at')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return (object) [
                    'id' => 'user_' . $user->id,
                    'activity_type' => 'User Registered',
                    'description' => "New user registered: {$user->name}",
                    'user_name' => $user->name,
                    'avatar_url' => $user->avatar_url,
                    'created_at' => $user->created_at,
                ];
            });

        // E-commerce activities
        if (config('modules.ecommerce.enabled', true)) {
            $orders = Order::with('user')
                ->latest('created_at')
                ->limit(5)
                ->get()
                ->map(function ($order) {
                    return (object) [
                        'id' => 'order_' . $order->id,
                        'activity_type' => 'Order Placed',
                        'description' => "New order #{$order->order_number} - $" . number_format($order->total_amount, 2),
                        'user_name' => $order->customer_name,
                        'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($order->customer_name) . '&background=random&color=fff&size=64',
                        'created_at' => $order->created_at,
                    ];
                });

            $activities = $activities->merge($orders);
        }

        // LMS activities
        if (config('modules.lms.enabled', true)) {
            $courses = Course::with('instructor')
                ->latest('created_at')
                ->limit(5)
                ->get()
                ->map(function ($course) {
                    return (object) [
                        'id' => 'course_' . $course->id,
                        'activity_type' => 'Course Created',
                        'description' => "Created course: {$course->title}",
                        'user_name' => $course->instructor->name ?? 'Unknown',
                        'avatar_url' => $course->instructor->avatar_url ?? '',
                        'created_at' => $course->created_at,
                    ];
                });

            $activities = $activities->merge($courses);
        }

        // CRM activities
        if (config('modules.crm.enabled', true)) {
            $clients = Client::latest('created_at')
                ->limit(5)
                ->get()
                ->map(function ($client) {
                    return (object) [
                        'id' => 'client_' . $client->id,
                        'activity_type' => 'Client Added',
                        'description' => "Added client: {$client->display_name}",
                        'user_name' => 'System',
                        'avatar_url' => $client->avatar_url,
                        'created_at' => $client->created_at,
                    ];
                });

            $deals = Deal::with('client')
                ->latest('created_at')
                ->limit(5)
                ->get()
                ->map(function ($deal) {
                    return (object) [
                        'id' => 'deal_' . $deal->id,
                        'activity_type' => 'Deal Created',
                        'description' => "Created deal: {$deal->title} - $" . number_format($deal->value, 2),
                        'user_name' => 'System',
                        'avatar_url' => 'https://ui-avatars.com/api/?name=D&background=random&color=fff&size=64',
                        'created_at' => $deal->created_at,
                    ];
                });

            $activities = $activities->merge($clients)->merge($deals);
        }

        // Merge all activities
        $activities = $activities
            ->merge($posts)
            ->merge($pages)
            ->merge($users)
            ->sortByDesc('created_at')
            ->take(20);

        // Convert to query builder format
        return new class($activities) extends Builder {
            protected $activities;

            public function __construct($activities)
            {
                $this->activities = $activities;
            }

            public function get()
            {
                return $this->activities;
            }

            public function orderBy($column, $direction = 'asc')
            {
                if ($column === 'created_at') {
                    $this->activities = $direction === 'desc' 
                        ? $this->activities->sortByDesc('created_at')
                        : $this->activities->sortBy('created_at');
                }
                return $this;
            }

            public function limit($value)
            {
                $this->activities = $this->activities->take($value);
                return $this;
            }
        };
    }

    protected function getActivityColor(string $type): string
    {
        return match ($type) {
            'Post Created' => 'primary',
            'Page Created' => 'info',
            'User Registered' => 'success',
            'Order Placed' => 'warning',
            'Course Created' => 'primary',
            'Client Added' => 'info',
            'Deal Created' => 'success',
            default => 'gray',
        };
    }
}